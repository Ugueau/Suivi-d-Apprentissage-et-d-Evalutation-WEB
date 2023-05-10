<?php

require_once __DIR__ . "/paramDefault.php";

/**
 * Class Database
 * pour une abstraction totale de la base de données, le but étant de simplifier le code
 */
class Database
{
    /**
     * @var null|PDO stocke l'instance de PDO
     */

    private ?PDO $pdo = null;



    /**
     * @const Si on est en mode production ou développement, car les erreurs seront affichées en mode dev, pas en prod
     */
    private const PRODUCTION = false;

    /**
     * @param string $password
     * @return string hashed
     */
    private function hash(string $password): string
    {
        // on choisira ici la méthode de hash de mot de passe
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Une fonction intermédiaire qui formate les conditions d'un select
     * @param array $data
     * @return array
     */
    private function conditions(array $data): array
    {
        $condition = "";
        $values = [];
        if (isset($data['password'])) { // on exclut password de la recherche, car on ne trouvera jamais de correspondance
            unset($data['password']);
        }
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $condition .= ($condition != "") ? " AND " : "";
                $operator = explode(" ", $key); // gestion des opérateurs dans les conditions : <= >= != <> LIKE
                if (isset($operator[1])) {
                    $condition .= $operator[0] . " " . $operator[1] . " ? ";
                } else {
                    $condition .= $operator[0] . " = ? ";
                }
                $values[] = $value;
            }
        }
        return [
            'condition' => $condition,
            'values' => $values,
        ];
    }

    /**
     * Initialise PDO si l'instance n'est pas créée, retourne l'instance sinon
     * @return PDO
     * @throws Exception
     */
    private function getPdo(): PDO
    {
        if (!$this->pdo) {
            try {
                $param = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]; // pour avoir les résultats sous forme d'objet
                if (!self::PRODUCTION) {
                    $param[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION; // on affiche les erreurs en mode dev uniquement
                }
                $this->pdo = new PDO(DSN, USER, PASSWORD, $param);
            } catch (PDOException $e) {
                throw new Exception("Erreur : " . $e->getMessage());
            }
        }
        return $this->pdo;
    }

    /**
     * Execute une requête sql en mode préparé
     *
     * @param string $query La requête à exécuter
     * @param array $values Les valeurs à injecter dans la requête préparée
     * @return PDOStatement En fonction du type de résultat généré par la requête
     * @throws Exception
     */
    public function query(string $query, array $values = []): PDOStatement
    {
        $statement = $this->getPdo()->prepare($query);
        if ($statement === false) {
            throw new Exception('Erreur de requête SQL');
        }


        $statement->execute($values);
        return $statement;
    }

    public function quote(string $s)
    {
        return $this->pdo->quote($s);
    }

    /**
     * Lire des données d'une $table en indiquant une série d'options au format d'un tableau (voir structure tableau $default)
     *
     * @param string $table Le nom de la table
     * @param array $options
     *  [
     *      "conditions" => ["champ" => "valeur"],
     *      "fields" => ['col1', 'col2', 'col6'],
     *      "limit" => 10,
     *      "offset" => 0,
     *      "order" => ['col5', 'col7 DESC']
     *  ]
     * @param bool $one Pour ne récupérer qu'un seul résultat
     * @return array|object Les résultats de la requête de recherche
     * @throws Exception
     */
    public function read(string $table, array $options = [], bool $one = false)
    {
        $options = array_merge(
            [
                "conditions" => [], // exemple : ["champ" => "valeur"] correspond à WHERE champ='valeur'
                "fields" => [], // exemple : ['col1', 'col2', 'col6'] correspond à SELECT col1,col2,col6 FROM ...
                "limit" => null, // exemple : 10 correspond à LIMIT 10
                "offset" => 0, // ne fonctionne que si limit est défini, en donnant une valeur numérique, correspondra à l'offset de départ
                "order" => [] // exemple : array('col5', 'col7 DESC') correspond à ORDER BY col5, col7 DESC
            ],
            $options
        );
        $condition = $this->conditions($options['conditions']);

        // on crée la chaine des champs à sélectionner
        if (count($options['fields']) > 0) {
            $fields = implode(',', $options['fields']);
        } else {
            $fields = "*";
        }

        $req = "SELECT " . $fields . " FROM " . $table;
        if ($condition['condition'] != "") {
            $req .= " WHERE " . $condition['condition'];
        }

        // on crée la chaine pour le ORDER BY
        if (count($options['order']) > 0) {
            $req .= " ORDER BY " . implode(', ', $options['order']);
        }

        // on ajoute la limite de la requête
        if ($options['limit']) {
            $req .= " LIMIT " . $options['offset'] . ", " . $options['limit'];
        }


        // on retourne les résultats
        $stmt = $this->query($req, $condition['values']);
        $result = $one ? $stmt->fetch() : $stmt->fetchAll();
        // Si password est dans les conditions, on vérifie la correspondance
        if ($one && isset($options['conditions']['password']) && !password_verify($options['conditions']['password'], $result->password)) {
            return (object) [];
        }
        return $result;
    }

    /**
     * getOne method pour récupérer le premier résultat de la requête
     *
     * @param string $table Le nom de la table
     * @param array $options Un tableau d'options pour construire la requête
     * @return object
     * @throws Exception
     */
    public function getOne(string $table, array $options = [])
    {
        return $this->read($table, $options, true);
    }


    /**
     * Ajoute des données dans la table (si l'id est défini dans $datas alors la requête fera un UPDATE
     * @param string $table le nom de la table
     * @param array $datas un tableau des valeurs à ajouter ex: array('col1' => 'val1', 'col2' => 'val2', 'col3' => 'val3', ...)
     * @return bool
     * @throws Exception
     */
    public function save(string $table, array $datas): bool
    {
        $id = null;
        if (isset($datas['id']) && is_numeric($datas['id'])) {
            $id = $datas['id'];
            unset($datas['id']);
        }
        if (!$datas) {
            return false;
        }
        if (isset($datas['password'])) { // on hache le mot de passe s'il fait partie des données
            $datas['password'] = $this->hash($datas['password']);
        }
        $keys = array_keys($datas);
        $values = substr(str_repeat('?,', count($keys)), 0, -1);
        if ($id) { // si l'id existe on va faire une mise à jour
            $fields = implode('=?, ', $keys);
            $req = "UPDATE " . $table . " SET $fields=? WHERE id=" . $id;
        } else { // sinon on fait une insertion
            $fields = implode(', ', $keys);
            $req = "INSERT INTO $table ($fields) VALUES ($values)";
        }
        return !($this->query($req, array_values($datas)) == false);
    }

    /**
     * Supprime un élément de la table dont l'id est $id
     * @param string $table Le nom de la table
     * @param int $id L'id de l'élément à supprimer
     * @return bool
     * @throws Exception
     */
    public function delete(string $table, int $id): bool
    {
        $req = "DELETE FROM " . $table . " WHERE id=" . $id;
        return $this->getPdo()->exec($req) == 1;
    }

    /**
     * Méthode pour faire un UPDATE sur une table
     * @param string $table
     * @param array $datas
     * @param array $conditions
     * @return bool|int Le nombre de champs concernés
     * @throws Exception
     */
    public function update(string $table, array $datas, array $conditions)
    {
        $search = $this->read($table, $conditions); // on vérifie s'il y a des correspondances dans la table selon les conditions demandées
        if (!$search) {
            return false; // retourne false si aucun résultat
        }
        $cpt = 0;
        foreach ($search as $value) {
            $cpt++;
            $datas["id"] = $value->id;
            $this->save($table, $datas); // met à jour chaque élément trouvé dans le $search
        }
        return $cpt;
    }

    /**
     * Cette méthode sert à récupérer toutes les compétences d'un IME
     * @param $idIME int l'id de l'IME
     * @return array
     * @throws Exception
     */
    public function getCompetences($idIME)
    {
        $query = $this->query("SELECT DISTINCT Competence.idCompetence as idCompetence, Competence.nom as nom, Competence.description as description, Categorie.idIME as idIME FROM Competence JOIN competenceCategorie JOIN Categorie ON Competence.idCompetence = competenceCategorie.idCompetence AND competenceCategorie.idCategorie = Categorie.idCategorie WHERE Categorie.idIME = :idIME", array("idIME" => $idIME));
        $listeCompetences = array();
        $result = $query->fetchAll();
        foreach ($result as $value) {
            $tmp = array(
                "idCompetence" => $value->idCompetence,
                "nom" => $value->nom,
                "description" => $value->description,
                "idIME" => $value->idIME,
                "recherche" => $value->nom
            );
            array_push($listeCompetences, $tmp);
        }
        return $listeCompetences;
    }
    /*
    public function getCompetencesADM($idIME, $idADM)
    {
        $query = $this->query("select DISTINCT Competence.idCompetence as idCompetence, Competence.nom as nom, Competence.description as description, Categorie.idIME as idIME FROM Competence JOIN competenceCategorie JOIN Categorie ON Competence.idCompetence = competenceCategorie.idCompetence AND competenceCategorie.idCategorie = Categorie.idCategorie
        WHERE Categorie.idIME = :idIME and Competence.idCompetence in (
        select Competence.idCompetence
        from ActiviteDuMoment
                              join competenceActivite on (ActiviteDuMoment.idActivite = competenceActivite.idActivite and ActiviteDuMoment.vers = competenceActivite.vers and ActiviteDuMoment.sous_vers = competenceActivite.sous_vers)
                             join Competence on Competence.idCompetence = competenceActivite.idCompetence
        where ActiviteDuMoment.idActiviteDuMoment = :idADM
        ); ", array("idIME" => $idIME, "idADM" => $idADM));
        $listeCompetences = array();
        $result = $query->fetchAll();
        foreach ($result as $value) {
            $tmp = array(
                "idCompetence" => $value->idCompetence,
                "nom" => $value->nom,
                "description" => $value->description,
                "idIME" => $value->idIME
            );
            array_push($listeCompetences, $tmp);
        }
        return $listeCompetences;
    }
    */

    /**
     * Cette méthode sert à récuperer l'ensemble des catégories d'un IME
     * @param $idIME int L'id de l'IME
     * @return array
     * @throws Exception
     */
    public function getCategories($idIME)
    {
        $query = $this->query("SELECT idCategorie, nom, description, idIME FROM Categorie WHERE idIME=" . $idIME);
        $listeCategories = array();
        $result = $query->fetchAll();
        foreach ($result as $value) {
            $tmp = array(
                "idCategorie" => $value->idCategorie,
                "nom" => $value->nom,
                "description" => $value->description,
                "idIME" => $value->idIME,
                "recherche" => $value->nom
            );
            array_push($listeCategories, $tmp);
        }
        return $listeCategories;
    }

    /**
     * Cette méthode sert à récuperer un élève
     * @param $idEleve int Id de l'élève
     * @param $idIME int Id de l'ime dans laquelle on le recherche
     * @return mixed|null
     */
    public function getEleve($idEleve, $idIME)
    {
        $listeEleve = $this->rechercherPersonne($idIME, 'eleve');
        foreach ($listeEleve as $eleve) {
            if ($eleve['id'] == $idEleve) {
                return $eleve;
            }
        }
        return null;
    }

    /**
     * Cette méthode permet de créer une Activité du moment
     * @param $idActivite int L'id de l'activité de référence
     * @param $ListeIdEleve array L'ensemble des élèves participant a l'activité du moment
     * @param $ListeIdEduc array L'ensemble des éducateurs supervisant cette activité du moment
     * @return mixed
     * @throws Exception
     */
    public function CreateActiviteDuMoment($idActivite, $ListeIdEleve, $ListeIdEduc)
    {

        $idActMoment = $this->query("select createActiviteDuMoment(:idAct) id", array(":idAct" => $idActivite));



        $idActMoment = $idActMoment->fetch();
        $idActMoment = $idActMoment->id;

        foreach ($ListeIdEleve as $id) {
            $this->query("call joue(:idPer,:idJouer)", array("idPer" => $id, "idJouer" => $idActMoment));
        }
        foreach ($ListeIdEduc as $id) {
            $this->query("call gere(:idPer,:idJouer)", array("idPer" => $id, "idJouer" => $idActMoment));
        }
        return $idActMoment;
    }
    public function getElevesADM($idADM)
    {
        $idActMoment = $this->query("select idPersonne from joue where idActiviteDuMoment=:idADM", array("idADM" => $idADM));
        $idActMoment = $idActMoment->fetchAll();
        $eleves = array();
        foreach ($idActMoment as $val) {
            array_push($eleves, $val->idPersonne);
        }
        return $eleves;
    }
    /**
     * Cette méthode permet d'inserer un nouvel élève dans une activité du moment
     * @param $idPersonne int l'id de l'élève a ajouter
     * @param $idADM int L'id de l'activité du moment à modifier
     * @return void
     * @throws Exception
     */
    public function Joue($idPersonne, $idADM)
    {
        $this->query("call joue(:idPer,:idJouer)", array("idPer" => $idPersonne, "idJouer" => $idADM));
    }

    /**
     * Cette méthode permet de retirer un élève d'une activité du moment
     * @param $idPersonne int l'id de l'élève a ajouter
     * @param $idADM int L'id de l'activité du moment à modifier
     * @return void
     * @throws Exception
     */
    public function NeJouePlus($idPersonne, $idADM)
    {
        $this->query("delete from joue where idActiviteDuMoment=:idADM and idPersonne=:idPer", array("idPer" => $idPersonne, "idADM" => $idADM));
    }

    /**
     * cette méthode permet de modifier la liste des competences d'une activité du moment
     * @param $idADM int L'id de l'activité du moment à modifier
     * @param $ListeIdCompetences array Liste de toutes les compétences
     * @return void
     * @throws Exception
     */
    public function modifyActiviteDuMoment($idADM, $ListeIdCompetences)
    {

        /*$prep = $this->query("SELECT * FROM competence where idActiviteDuMoment=:id", array('id' => $idADM));
        $result = $prep->fetchAll();
        $oldCompId = array();
        foreach ($result as $idComp) {
            if (!in_array($idComp->idCompetence, $ListeIdCompetences)) array_push($oldCompId, $idComp->idCompetence);
        }*/

        $prep = $this->query("SELECT modifyADM(:id) sous_vers", array('id' => $idADM));
        $result = $prep->fetch();
        $sous_version = $result->sous_vers;
        $prep = $this->query("SELECT vers, idActivite FROM ActiviteDuMoment WHERE idActiviteDuMoment = :idADM", array("idADM" => $idADM));
        $result = $prep->fetch();
        $version = $result->vers;
        $idActivite = $result->idActivite;

        foreach ($ListeIdCompetences as $elem) {
            $prep = $this->query("call competenceActivite(:idComp, :idAct, :version, :sous_version)", array('idComp' => $elem, 'idAct' => $idActivite, 'version' => $version, 'sous_version' => $sous_version));
            $prep->fetch();
        }
        // foreach ($oldCompId as $elem) {
        //     $prep = $this->query("call competenceActivite(:idComp, :idAct, :version, :sous_version)", array('idComp' => $elem, 'idAct' => $idActivite, 'version' => $version, 'sous_version' => $sous_version));
        //     $prep = $prep->fetch();
        // }
    }


    public function VersionApplication(){
        $prep = $this->query("select getVersionApplication() version", array());
        $prep = $prep->fetch();
        return $prep->version;
    }

    public function modifyActiviteDuMomentFullListIdComp($idADM, $ListeIdCompetences)
    {
        $prep = $this->query("SELECT modifyADM(:id) sous_vers", array('id' => $idADM));
        $result = $prep->fetch();
        $sous_version = $result->sous_vers;
        $prep = $this->query("SELECT vers, idActivite FROM ActiviteDuMoment WHERE idActiviteDuMoment = :idADM", array("idADM" => $idADM));
        $result = $prep->fetch();
        $version = $result->vers;
        $idActivite = $result->idActivite;

        foreach ($ListeIdCompetences as $elem) {
            $prep = $this->query("call competenceActivite(:idComp, :idAct, :version, :sous_version)", array('idComp' => $elem, 'idAct' => $idActivite, 'version' => $version, 'sous_version' => $sous_version));
            $prep = $prep->fetch();
        }
    }

    /**
     *
     * @param $idIME
     * @param $type
     * @return array
     * @throws Exception
     */
    public function rechercherPersonne($idIME, $type)
    {
        $Liste = array();
        if ($type == 'eleve') {
            $ListeEleve = $this->query("select idPersonne,nom, prenom, numeroHomonyme,group_concat(idIME)idIME from Personne natural join Eleve e natural join etudie ee group by 1");
        } elseif ($type == 'educateur') {
            $ListeEleve = $this->query("select idPersonne,nom, prenom, numeroHomonyme,group_concat(idIME)idIME from Personne natural join Educateur e natural join enseigne ee group by 1");
        }

        $result = $ListeEleve->fetchAll();
        foreach ($result as $value) {
            if (!(strpos($value->idIME, $idIME) === false)) {
                $Tmp = array(
                    "id" => $value->idPersonne,
                    "nom" => $value->nom,
                    "prenom" => $value->prenom,
                    "numeroHomonyme" => $value->numeroHomonyme,
                    "type" => "eleve",
                    "idIME" => $value->idIME,
                    "recherche"=>$value->nom." ".$value->prenom
                );
                //$Tmp = new Personne($value->idPersonne, $value->nom, $value->prenom, $value->numeroHomonyme, "eleve", $value->idIME);
                array_push($Liste, $Tmp);
            }
        }
        return $Liste;
    }

    /**
     * Cette methode permet de récuperer la liste des activités d'un IME
     * @param $idIME L'id de l'IME voulue
     * @return array
     * @throws Exception
     */
    public function rechercherArticle($idIME)
    {
        $ListeActivite = $this->query("select idActivite,  nom, description, idIME from Activite where idIME = :idIME", array("idIME" => $idIME));
        $result = $ListeActivite->fetchAll();
        $ListeActivite = array();
        foreach ($result as $value) {
            //$Tmp = new Activite($value->idActivite, $value->nom, $value->description, $value->idIME);
            $Tmp = array(
                "idActivite" => $value->idActivite,
                "nom" => $value->nom,
                "description" => $value->description,
                "idIME" => $value->idIME,
                "recherche"=>$value->nom
            );
            array_push($ListeActivite, $Tmp);
        }
        return $ListeActivite;
    }

    /**
     * Cette methode permet de créer une nouvelle activité
     * @param $nom Nom de l'activité
     * @param $desc Description de l'activité
     * @param $idIME L'id de l'IME ou l'activité devra etre ajoutée
     * @param $ListeIdCompetences Liste des competence à a jouter dans l'activité
     * @return void
     * @throws Exception
     */
    public function createActivite($nom, $desc, $idIME, $ListeIdCompetences)
    {
        $prep = $this->query("select createActivite(:nom, :desc, :idIME) id", array('nom' => $nom, 'desc' => $desc, 'idIME' => $idIME));
        $idAct = $prep->fetch()->id;

        foreach ($ListeIdCompetences as $value) {
            $prep = $this->query("call competenceActivite(:idComp, :idAct, 1, 0)", array('idComp' => $value, 'idAct' => $idAct));
            $prep = $prep->fetch();
        }
    }

    /**
     * Cette methode permet de modifier la listes des competence d'une activité, cela modifie egalement la version de l'activité
     * @param $idAct L'id de l'activité à modifier
     * @param $nom Le nom de l'activité modifiée
     * @param $desc La description de l'activité modifiée
     * @param $ListeIdCompetences La nouvelle liste de competence de l'activité
     * @return void
     * @throws Exception
     */
    public function modifyActivite($idAct, $nom, $desc, $ListeIdCompetences)
    {
        $prep = $this->query("SELECT modifyActivite(:id, :nom, :desc) version", array('id' => $idAct, 'nom' => $nom, 'desc' => $desc));
        $version = $prep->fetch()->version;

        foreach ($ListeIdCompetences as $elem) {
            $prep = $this->query("call competenceActivite(:idComp, :idAct, :version, 0)", array('idComp' => $elem, 'idAct' => $idAct, 'version' => $version));
            $prep = $prep->fetch();
        }
    }

    /**
     * Cette methode permet de retirer une competence d'une categorie
     * @param $idCategorie L'id de la categorie a modifier
     * @param $idCompetence L'id de la competence a retirer
     * @return void
     * @throws Exception
     */
    function deleteCompetenceFromCategorie($idCategorie, $idCompetence)
    {
        $query = $this->query("DELETE FROM competenceCategorie WHERE idCategorie=:idCat AND idCompetence=:idComp", array('idCat' => $idCategorie, 'idComp' => $idCompetence));
        $query->fetch();
    }

    /**
     * Cette methode permet de créer une nouvelle competence
     * @param $nom Le nom de la nouvelle competence
     * @param $desc La description de la competence
     * @param $ListeIdCategories La liste des categorie de cette competence
     * @return mixed
     * @throws Exception
     */
    public function createCompetence($nom, $desc, $ListeIdCategories)
    {
        $prep = $this->query("select createCompetence(:nom, :desc) idComp", array('nom' => $nom, 'desc' => $desc));
        $idComp = $prep->fetch()->idComp;
        foreach ($ListeIdCategories as $value) {
            $prep = $this->query("select competenceCategorie(:idComp,:idCat)", array('idComp' => $idComp, 'idCat' => $value));
            $prep->fetch();
        }
        return $idComp;
    }

    /**
     * Cette methode permet de créer une nouvelle categorie
     * @param $nom Le nom de la nouvelle categorie
     * @param $desc la Description de la nouvelle categorie
     * @param $idIME L'id de l'IME de la categorie
     * @return void
     * @throws Exception
     */
    public function createCategorie($nom, $desc, $idIME)
    {
        $prep = $this->query("call createCategorie(:nom, :desc, :idIME);", array('nom' => $nom, 'desc' => $desc,'idIME' => $idIME));
    }

    /**
     * Cette methode permet de comparer un mot de passe à celui d'un utilisateur
     * @param $id L'id de l'utilisateur
     * @param $mdp Le mot de passe à comparer
     * @return bool
     * @throws Exception
     */
    public function verifyPassWord($id, $mdp)
    {

        $verif = $this->query("select getPassWord(:id)mdp", array('id' => $id));

        if ($verif) {
            $resulat = $verif->fetch();
            if (password_verify($mdp, $resulat->mdp)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Cette methode permet de tester la connexion d'un utilisateur
     * @param $nom Le nom de la personne se connectant
     * @param $prenom Le prenom de la personne se connectant
     * @param $num Le numero Homonyme de la personne se connectant
     * @param $mdp Le mot de passe de la personne se connectant
     * @return int|void
     * @throws Exception
     */
    public function VerifConnect($nom, $prenom, $num, $mdp)
    {

        $idPrep = $this->query("select getid(:nom,:prenom,:numH) id", array('nom' => $nom, 'prenom' => $prenom, 'numH' => $num));
        $idPrep = $idPrep->fetch();
        if ($idPrep->id != -1) {
            $id = $idPrep->id;
            $isFirstCo = $this->query("select isFistConnexion(:id) result", array('id' => $id));
            if ($isFirstCo) {
                $isFirstCo = $isFirstCo->fetch();
                if (!$isFirstCo->result) {
                    if ($this->verifyPassWord($id, $mdp)) return $id;
                    else return -3;
                } else return -2;
            }
        } else {
            return -1;
        }
    }

    /**
     * Cette methode permet de récuperer le numero homonyme d'une personne
     * @param $nom Le nom de la personne
     * @param $prenom Le prenom de la personne
     * @param $mdp Le mot de passe de la personne
     * @return void
     * @throws Exception
     */
    public function getNumeroHomonymeFirstCo($nom, $prenom, $mdp)
    {

        $NumPrep = $this->query("select mot_de_passe mdp, numeroHomonyme num from Personne where nom=:nom and prenom=:prenom and premiereConnexion=true", array('nom' => $nom, 'prenom' => $prenom));

        $NumPrep = $NumPrep->fetchall();
        foreach ($NumPrep as $value) {
            if (password_verify($mdp, $value->mdp)) {
                return $value->num;
            }
        }
    }

    /**
     * Cette methode permet de verifier la connexion d'un utilisateur lors de sa première connexion
     * @param $nom Le nom de la personne se connectant
     * @param $prenom Le prenom de la personne se connectant
     * @param $mdp le mot de passe de la personne se connectant
     * @return int|void
     * @throws Exception
     */
    public function VerifFirstConnect($nom, $prenom, $mdp)
    {
        $num = $this->getNumeroHomonymeFirstCo($nom, $prenom, $mdp);

        if ($num == -1) return -1;
        else {

            $idPrep = $this->query("select getid(:nom,:prenom,:numH) id", array('nom' => $nom, 'prenom' => $prenom, 'numH' => $num));

            if ($idPrep) {
                $idPrep = $idPrep->fetch();
                $id = $idPrep->id;
                $isFirstCo = $this->query("select isFistConnexion(:id) result", array('id' => $id));
                if ($isFirstCo) {
                    $isFirstCo = $isFirstCo->fetch();
                    if ($isFirstCo->result) {
                        return $id;
                    } else return -2;
                }
            }
        }
    }

    /**
     * Cette methode permet de modifier le mot de passe d'un utilisateur
     * @param $id L'id de la personne changeant son mot de passe
     * @param $mdp Le nouveau mot de passe
     * @return PDOStatement
     * @throws Exception
     */
    public function ModifyPassWord($id, $mdp)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $UpdateMdp = $this->query("call modifyPassword(:id,:mdp)", array('id' => $id, 'mdp' => $mdp));
        return $UpdateMdp;
    }

    /**
     * Cette methode permet de creer un IME
     * @param $nom Le nom de l'IME
     * @param $adress L'adresse de l'IME
     * @return PDOStatement
     * @throws Exception
     */
    function CreateIME($nom,$adress){
        $CreateIME = $this->query("call CreateIME(:IME, :desc)", array("IME" => $nom, "desc" => $adress));
        return $CreateIME;
    }

    /**
     * Cette methode permet de modifier un IME
     * @param $id L'id de l'IME
     * @param $nom Le nouveau nom
     * @param $adress La nouvelle addresse
     * @return PDOStatement
     * @throws Exception
     */
    function UpdateIME($id,$nom,$adress){
        $CreateIME = $this->query("UPDATE IME SET nom = :nom, adresse = :adresse WHERE idIME = :idIME", array("nom" => $nom, "adresse" => $adress, "idIME" => $id));
        return $CreateIME;
    }

    /**
     * Cette methode permet de supprimer un IME
     * @param $id L'id de l'IME
     * @return PDOStatement
     * @throws Exception
     */
    function DeleteIME($id){
        $res = $this->query("delete from IME where idIME = :idIME", array("idIME"=>$id));
        return $res;
    }

    /**
     * Cette methode permet supprimer un personnel (Educateur, Responsable, Directeur, Administrateur)
     * @param $id L'id de la personne à supprimer
     * @return PDOStatement
     * @throws Exception
     */
    function DeletePersonnel($id){
        $res = $this->query("delete from Personne where idPersonne=:id", array("id"=>$id));
        return $res;
    }
    /**
     * Cette methode permet de créer un nouvel élève
     * @param $nom Le nom de l'élève
     * @param $prenom le prenom de l'élève
     * @param $mdp Le mot de passe de l'élève
     * @return mixed
     * @throws Exception
     */
    function CreateEleve($nom, $prenom, $mdp)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stm = $this->query("select createEleve(:nom, :prenom, :mdp) id", array('nom' => $nom, 'prenom' => $prenom, 'mdp' => $mdp));
        return $stm->fetch();
    }

    /**
     * Cette methode permet de créer un Administrateur
     * @param $nom Le nom de l'administrateur
     * @param $prenom Le prenom de l'administrateur
     * @param $mdp Le mot de passe de l'administrateur
     * @return mixed
     * @throws Exception
     */
    public function CreateAdministrateur($nom, $prenom, $mdp)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stm = $this->query("select CreateAdministrateur(:nom, :prenom, :mdp) id", array('nom' => $nom, 'prenom' => $prenom, 'mdp' => $mdp));
        return $stm->fetch();
    }

    /**
     * Cette methode permet de créer un nouveau directeur
     * @param $nom Le nom du directeur
     * @param $prenom Le prenom du directeur
     * @param $mdp Le mot de passe du directeur
     * @return mixed
     * @throws Exception
     */
    public function CreateDirecteur($nom, $prenom, $mdp)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stm = $this->query("select CreateDirecteur(:nom, :prenom, :mdp) id", array('nom' => $nom, 'prenom' => $prenom, 'mdp' => $mdp));
        return $stm->fetch();
    }

    /**
     * Cette methode permet de créer un educateur
     * @param $nom Le nom de l'éducateur
     * @param $prenom Le prenomm de l'éducateur
     * @param $mdp Le mot de passe de l'éducateur
     * @return mixed
     * @throws Exception
     */
    public function CreateEducateur($nom, $prenom, $mdp)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stm = $this->query("select CreateEducateur(:nom, :prenom, :mdp) id", array('nom' => $nom, 'prenom' => $prenom, 'mdp' => $mdp));
        return $stm->fetch();
    }

    /**
     * Cette methode permet de créer un nouveau responsable
     * @param $nom Le nom du responsable
     * @param $prenom Le prenom du responsable
     * @param $mdp Le mot de passe du responsable
     * @param $IME L'IME dans laquelle il est responsable
     * @return mixed
     * @throws Exception
     */
    public function CreateResponsable($nom, $prenom, $mdp, $IME)
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stm = $this->query("select CreateResponsable(:nom, :prenom, :mdp, :IME) id", array('nom' => $nom, 'prenom' => $prenom, 'mdp' => $mdp, 'IME' => $IME));
        return $stm->fetch();
    }

    /**
     * Cette méthode permet de créer/modifier les résultats d'une competence dans une activité du moment
     * @param $idComp L'id de la competence
     * @param $idADM L'id de l'activité du moment
     * @param $idPers L'id de la personne
     * @param $note La note a ajouter
     * @return PDOStatement
     * @throws Exception
     */
    public function createModifyResultat($idComp, $idADM, $idPers, $note)
    {
        $tmp = $this->query("call createModifyResultat(:idComp,:idADM,:idPers,:note)", array(
            "idComp" => $idComp,
            "idADM" => $idADM,
            "idPers" => $idPers,
            "note" => $note
        ));
        return $tmp;
    }

    /**
     * Cette méthode permet de clonner une activité du moment en conservant le même joueur et les mêmes competence
     * @param $idADM L'id de l'activité du moment a clonner
     * @return false
     * @throws Exception
     */
    public function rejouer($idADM)
    {
        $idActMoment = $this->query("select rejouer(:idADM) id", array(":idADM" => $idADM));
        if ($idActMoment) {
            $idActMoment = $idActMoment->fetch();
            return $idActMoment->id;
        }
        return false;
    }

    /**
     * Cette methode permet de récupérer l'id d'un utilisateur grace à son token d'API
     * @param $token Le token de l'API
     * @return null
     * @throws Exception
     */
    function GetId($token)
    {
        $getPersonne = $this->query("select getIdToken(:token) id", array('token' => $token));
        $out = $getPersonne->fetch();
        if (!empty($out)) {
            return $out->id;
        } else {
            return null;
        }
    }

    /**
     * Cette methode permet de récuperer le Type d'utilisateur d'une personne (eleve, educateur, responsable, directeur, administrateur)
     * @param $id L'id de la personne
     * @return null
     * @throws Exception
     */
    function GetType($id)
    {
        $getPersonne = $this->query("select getType(:id) type", array('id' => $id));
        $out = $getPersonne->fetch();
        if (!empty($out)) {
            return $out->type;
        } else {
            return null;
        }
    }

    /**
     * Cette methode permet de récuperer la liste des activités qu'a effectuées un élève durant une periode (si aucune d'ate n'est entré la methode renvoie l'ensemble des activité joué par l'élève)
     * @param $idEleve L'id de l'élève
     * @param $start_date La date de début
     * @param $end_date La date de fin
     * @return array
     * @throws Exception
     */
    function getActivitesPlayed($idEleve, $start_date = null, $end_date = null)
    {
        if ($start_date == null) {
            $start_date = new DateTime("2022-01-01");
        }
        if ($end_date == null) {
            $today = new DateTime();
            $today->setTimezone(new DateTimeZone("Europe/Paris"));
            $end_date = $today;
        }
        if (!($start_date instanceof Database) && !($end_date instanceof DateTime)) {
            $start_date = new DateTime($start_date);
            $end_date = new DateTime($end_date);
        }
        $activitesPlayed = $this->query(
            "SELECT ActiviteDuMoment.dateHeure as dateHeure, ActiviteDuMoment.idActiviteDuMoment as idADM, Activite.idActivite as idActivite, Activite.nom as nom, Activite.description as d
                                        FROM joue JOIN ActiviteDuMoment JOIN Activite
                                            ON joue.idActiviteDuMoment = ActiviteDuMoment.idActiviteDuMoment AND ActiviteDuMoment.idActivite = Activite.idActivite
                                        WHERE idPersonne = :idEleve AND (ActiviteDuMoment.dateHeure BETWEEN :start_date AND :end_date) order by dateHeure desc",
            array('idEleve' => $idEleve, "start_date" => $start_date->format("Y-m-d") . " 00:00:00", "end_date" => $end_date->format("Y-m-d") . " 23:59:59")
        );
        $results = $activitesPlayed->fetchAll();
        $activites = array();
        foreach ($results as $activite) {
            $tmp = array(
                "idADM" => $activite->idADM,
                "idActivite" => $activite->idActivite,
                "nom" => $activite->nom,
                "description" => $activite->d,
                "dateHeure" => $activite->dateHeure
            );
            array_push($activites, $tmp);
        }
        return $activites;
    }

    /**
     * Cette methode retourne l'ensemble des résultats d'un élève lors d'une activité du moment
     * @param $idEleve L'id de l'eleve
     * @param $idADM L'id de l'activité du moment
     * @return array
     * @throws Exception
     */
    function getCompetencesAndResultats($idEleve, $idADM)
    {
        $query = $this->query("SELECT resultat.note as note, Competence.idCompetence as idCompetence, Competence.nom as nom, Competence.description as description
                               FROM resultat JOIN Competence
                                    ON resultat.idCompetence = Competence.idCompetence
                                WHERE resultat.idActiviteDuMoment = :idADM AND idPersonne = :idEleve", array("idADM" => $idADM, "idEleve" => $idEleve));
        $results = $query->fetchAll();
        $return_value = array();
        foreach ($results as $element) {
            $tmp = array(
                "note" => $element->note,
                "idCompetence" => $element->idCompetence,
                "nom" => $element->nom,
                "description" => $element->description
            );
            array_push($return_value, $tmp);
        }
        return $return_value;
    }

    /**
     * Cette methode renvoie la liste des competences d'une categorie
     * @param $idCategorie L'id de la categorie
     * @return array
     * @throws Exception
     */
    function getCompetencesOfCategorie($idCategorie)
    {
        $query = $this->query("SELECT Competence.idCompetence as idCompetence, Competence.nom as nom, Competence.description as description
                               FROM Competence JOIN  competenceCategorie JOIN Categorie
                                ON Competence.idCompetence = competenceCategorie.idCompetence AND competenceCategorie.idCategorie = Categorie.idCategorie
                              WHERE Categorie.idCategorie = :idCategorie", array("idCategorie" => $idCategorie));
        $results = $query->fetchAll();
        $return_value = array();
        foreach ($results as $element) {
            $tmp = array(
                "idCompetence" => $element->idCompetence,
                "nom" => $element->nom,
                "description" => $element->description
            );
            array_push($return_value, $tmp);
        }
        return $return_value;
    }

    /**
     * Cette methode permet de récuperer les résultats d'un eleve sur une competence
     * @param $eleveId L'id de l'eleve
     * @param $idCompetence L'id de la competence
     * @return array
     * @throws Exception
     */
    function getResultatsByCompetence($eleveId, $idCompetence)
    {
        $query = $this->query("SELECT idCompetence, idActiviteDuMoment as idADM, idPersonne as idEleve, note
                               FROM resultat 
                               WHERE resultat.idCompetence = :idCompetence AND resultat.idPersonne = :eleveId", array("idCompetence" => $idCompetence, "eleveId" => $eleveId));
        $results = $query->fetchAll();
        $return_value = array();
        foreach ($results as $element) {
            $tmp = array(
                "idCompetence" => $element->idCompetence,
                "idADM" => $element->idADM,
                "idEleve" => $element->idEleve,
                "note" => $element->note
            );
            array_push($return_value, $tmp);
        }
        return $return_value;
    }

    /**
     * Cette methode renvoie la liste des IMEs
     * @return array
     * @throws Exception
     */
    function getIMEs() {
        $query = $this->query("SELECT idIME, nom, adresse FROM IME");
        $results = $query->fetchAll();
        $return_value = array();
        foreach($results as $result) {
            $tmp = array(
                "idIME" => $result->idIME,
                "nom" => $result->nom,
                "adresse" => $result->adresse,
                "recherche" => $result->nom
            );
            array_push($return_value, $tmp);
        }
        return $return_value;
    }
    function getPersonnels(){
        $query = $this->query("select * from personnel");
        $result = $query->fetchAll();
        $Liste = array();

        foreach ($result as $value) {
            $Tmp = array(
                "id" => $value->idPersonne,
                "nom" => $value->nom,
                "prenom" => $value->prenom,
                "numeroHomonyme" => $value->numeroHomonyme,
                "type" => $value->type,
                "ListeIME" => $value->imes,
                "recherche"=>$value->nom." ".$value->prenom);
            array_push($Liste, $Tmp);
                //$Tmp = new Personne($value->idPersonne, $value->nom, $value->prenom, $value->numeroHomonyme, "eleve", $value->idIME);


        }
        return $Liste;
    }

    /**
     * Cette méthode remplace les informations d'une personne par les informations rentrées en paramètre dans la base
     * de données.
     *
     * Si vous ne voulez pas modifier une information, renseignez le champ par la même valeur que celle qui est déjà
     * présente dans la base de données.
     *
     * Cas directeur : l'idIME n'est pas pris en compte (vous pouvez mettre -1)
     *
     * @param $idPersonne int Id de la personne à modifier
     * @param $nom string Le nouveau nom (ou l'ancien)
     * @param $prenom string Le nouveau prénom (ou l'ancien)
     * @param $type string Le nouveau type (pris en charge : 'educateur', 'responsable', 'directeur') (ou l'ancien)
     * @param $idIME int L'id du nouvel IME (ou de l'ancien)
     * @return int Renvoie l'id de la personne
     */
    function modifyPersonne($idPersonne, $nom, $prenom, $type , $idIME) {
        $query = $this->query('SELECT ModifyPersonne(:id, :nom, :prenom, :type, :ime) id',
            array("id" => $idPersonne,
                  "nom" => $nom,
                  "prenom" => $prenom,
                  "type" => $type,
                  "ime" => $idIME));
        $result = $query->fetch();
        return $result->id;
    }
    function isInstalationProd(){
        $query = $this->query("select count(*) nbr from Personne",array());
        $result = $query->fetch();
        if($result->nbr==0){
            return true;
        }
        else{
            return false;
        }
    }
}
