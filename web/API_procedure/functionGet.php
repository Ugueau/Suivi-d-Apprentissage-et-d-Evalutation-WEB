<?php


function GetPersonne($id, $token, $db = null)
{

    $idSender = $db->GetId($token);

    if ($idSender > 0) {

        $getPersonne = $db->query("call getPersonne(:id,@nom,@prenom,@numeroH,@type,@idIME,@nomIME); select @nom nom ,@prenom prenom ,@numeroH numeroHomonyme,@type type,@idIME idIME,@nomIME nomIME", array('id' => $id));
        $getPersonne->nextRowset();
        $out = $getPersonne->fetch();
        $idIME = explode(',', $out->idIME);
        $nomIME = explode(',', $out->nomIME);

        $TmpPersonne = array(
            "id" => $id,
            "nom" => $out->nom,
            "prenom" => $out->prenom,
            "numeroHomonyme" => $out->numeroHomonyme,
            "type" => $out->type,
            "idIMESelected" => $idIME[0]
        );
        $cpt = 0;
        foreach ($idIME as $val) {
            $TmpPersonne["ListeIME"][$val] = array(
                "id" => $val,
                "nom" => $nomIME[$cpt]
            );
            $cpt++;
        }

        echo json_encode($TmpPersonne, JSON_UNESCAPED_UNICODE);
        //sendJson($TmpPersonne, $idSender, $db);
    } else {
        throw new Exception("token incorrect", 11);
    }
}


function GetEleves($ime, $token, $db = null)
{
    $idSender = $db->GetId($token);

    if ($idSender > 0) {
        $stm = $db->query("select p.idPersonne idPersonne, p.nom, p.prenom, p.numeroHomonyme from Personne p join Eleve e on p.idPersonne = e.idPersonne join etudie et on e.idPersonne = et.idPersonne where et.idIME =:IME", array("IME" => $ime));
        $result = $stm->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->idPersonne] = $val;
        }

        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de récuperer la liste des éducateurs d'un IME
 * @param $ime L'id de l'IME
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getEducateurs($ime, $token, $db = null)
{
    $idSender = $db->GetId($token);

    if ($idSender > 0) {
        $stm = $db->query("select p.idPersonne, p.nom, p.prenom, p.numeroHomonyme from Personne p join Educateur e on p.idPersonne = e.idPersonne join enseigne en on e.idPersonne = en.idPersonne where en.idIME =:IME", array("IME" => $ime));
        $result = $stm->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->idPersonne] = $val;
        }

        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de récuperer la liste des activités d'un IME
 * @param $ime L'id de L'IME
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getActivite($ime, $token, $db = null)
{
    $idSender = $db->GetId($token);

    if ($idSender > 0) {

        $stm = $db->query("select * from Activite a where a.idIME=:IME", array("IME" => $ime));
        $result = $stm->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->idActivite] = $val;
        }

        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de récuperer la liste de competence d'une activité du moment
 * @param $idActiviteDuMoment L'id de l'activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getActiciteDuMomentCompetance($idActiviteDuMoment, $token, $db = null){
    $idSender = $db->GetId($token);
    if ($idSender > 0) {

        $stm = $db->query("select idCompetence, nomCompetence,descCompetence from competence where idActiviteDuMoment=:idADM", array("idADM" => $idActiviteDuMoment));
        $result = $stm->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->idCompetence] = $val;
        }

        if(count($tmp)==0){
            $tmp=null;
        }

        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);

    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de récupérer la liste des résultats d'une activité du moment
 * @param $idActiviteDuMoment L'id de l'activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getActiciteDuMomentResultat($idActiviteDuMoment, $token, $db = null){
    $idSender = $db->GetId($token);
    if ($idSender > 0) {

        $stm = $db->query("select idPersonne, idCompetence,note from activiterDuMoment where idActiviteDuMoment=:idADM", array("idADM" => $idActiviteDuMoment));
        $result = $stm->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->idPersonne."-".$val->idCompetence] = $val;
        }
        if(count($tmp)==0){
            $tmp=null;
        }

        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);

    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette methode permet de récuperer la liste des activités du moment supervisé par l'educateur possedant le token passé en parametre
 * @param $ime L'id de l'IME
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getHistorique($ime, $token, $db = null)
{
    $idSender = $db->GetId($token);
    if ($idSender > 0) {
        $histo = $db->query("select am.idActiviteDuMoment id,  a.idActivite activite , am.dateHeure date ,group_concat(p.idPersonne) eleves 
        from ActiviteDuMoment am 
        join Activite a on am.idActivite=a.idActivite 
        join gere g on g.idActiviteDuMoment=am.idActiviteDuMoment
        left join joue j on j.idActiviteDuMoment=am.idActiviteDuMoment 
        left join Personne p on p.idPersonne=j.idPersonne
        where g.idPersonne=:id
        and a.idIME=:idIME
        group by 1
        order by 3 desc
        limit 20", array(
            'id' => $idSender,
            "idIME" => $ime
        ));
        $result = $histo->fetchAll();

        $tmp = array();
        foreach ($result as $val) {
            $tmp[$val->id] = $val;
        }
        if(count($tmp)==0){
            throw new Exception("vide");
        }
        else{
            echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
        }
        
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette methode permet de recuperer le responsable d'un IME
 * @param $ime L'id de l'IME du responsable a recuperer
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getResponsables($ime, $token, $db = null)
{
    $idSender = $db->GetId($token);

    if ($idSender > 0) {
        $stm = $db->query("select p.idPersonne, p.nom, p.prenom, p.numeroHomonyme from Personne p join Responsable r on p.idPersonne = r.idPersonne where r.idIME =:IME", array("IME" => $ime));
        $result = $stm->fetchAll();

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de tester la connexion d'une personne et de lui renvoyer son token si le login
 * et le mot de passe sont corrects
 * @param $login Le login
 * @param $mdp Le mot de passe
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 12 -> Nom d'utilisateur ou mot de passe incorrect
 */
function getConnexion($login, $mdp, $db = null)
{

    $nom = "";
    $prenom = "";
    $num = 0;

    if (traitementConnexion($nom, $prenom, $num, $login)) {

        $id = $db->VerifConnect($nom, $prenom, $num, $mdp);
        if ($id ==-2) {
            throw new Exception("Premiere Connextion", 13);
        }
        else if ($id == -1) {
            throw new Exception("Nom d'utilisateur ou mot de passe incorrecte", 12);
        }else if($id == -3){
            throw new Exception("Nom d'utilisateur ou mot de passe incorrecte", 12);
        }
        else {

            $stm = $db->query("select insertToken(:id) as token", array('id' => $id));
            $result = $stm->fetch();
            $token = $result->token;

            $id = $db->GetId($token);

            $type = $db->GetType($id);

            echo json_encode(array("token" => $token, "type" => $type), JSON_UNESCAPED_UNICODE);
        }
    } else {
        throw new Exception("Nom d'utilisateur ou mot de passe incorrecte", 12);
    }
}

/**
 * Cette fonction permet de recuperer la liste des competence d'une activité
 * @param $token Le token de la personne executant la requete
 * @param $idActivite L'id de l'activite
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getCompetanceActivite($token,$idActivite, $db){
    $id = $db->GetId($token);

    if($id > 0){
        $stm = $db->query("select c.idCompetence,c.nom,c.description from competenceActivite ca join Activite a on a.idActivite=ca.idActivite join Competence c on ca.idCompetence=c.idCompetence where a.idActivite=:idActivite and a.vers=ca.vers and ca.sous_vers=0", array('idActivite' => $idActivite));
        $stm=$stm->fetchall();
        $Competence = array();
        foreach($stm as $val){
            array_push($Competence,array("id"=>$val->idCompetence,"nom"=>$val->nom,"description"=>$val->description));
        }
        echo json_encode(array("resultat" => $Competence), JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de recuperer l'ensemble des categories et les competences associées dans un IME
 * @param $token Le token de la personne executant la requete
 * @param $idIME l'ID de l'IME
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getModelCompetenceCategorie($token, $idIME, $db){
    $id = $db->GetId($token);

    if($id > 0){
        $listCategorie = array();
        $prep = $db->query("select idCategorie, nom, description from Categorie where idIME = :idIME", array("idIME" => $idIME));
        $result = $prep->fetchall();
        foreach($result as $value){
            array_push($listCategorie, array("idCategorie" => $value->idCategorie, "nom" => $value->nom, "description" => $value->description));
        }
        
        $listCompetence = array();
        $prep = $db->query("select distinct(c.idCompetence), c.nom, c.description from Competence c
        join competenceCategorie cc on c.idCompetence = cc.idCompetence
        join Categorie ca on cc.idCategorie = ca.idCategorie
        where ca.idIME = :idIME" , array("idIME" => $idIME));   
        $result = $prep->fetchall();
        foreach($result as $value){
            $prep = $db->query("select ca.idCategorie from Competence c
            join competenceCategorie cc on c.idCompetence = cc.idCompetence
            join Categorie ca on cc.idCategorie = ca.idCategorie
            where ca.idIME = :idIME and c.idCompetence = :idComp;" , array("idIME" => $idIME, "idComp" => $value->idCompetence));   
            $catListResult = $prep->fetchall();
            $catListComp = array();
            foreach($catListResult as $val){
                array_push($catListComp, $val->idCategorie);
            }
            array_push($listCompetence, array("id" => $value->idCompetence, "nom" => $value->nom, "description" => $value->description, "listeCategorieCompetence" => $catListComp));
        }
        $retour = array("listeCategorie" => $listCategorie, "listeCompetence" => $listCompetence);
        echo(json_encode($retour));
    }
    else{
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette methode permet de recuperer la liste des activtiés du moment effectuées par un élève dans une periode
 * @param $token Le token de la personne executant la requete
 * @param $db Il s'agit de l'instance de la classe Database
 * @param $idEleve L'id de l'élève
 * @param $start_date La date de debut de la selection
 * @param $end_date La date de fin
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getActivitesPlayedAPI($token,$db, $idEleve, $start_date = null, $end_date = null){
    $id = $db->GetId($token);

    if($id > 0){
        $stm = $db->getActivitesPlayed($idEleve, $start_date, $end_date);
        echo json_encode(array("resultat" => $stm), JSON_UNESCAPED_UNICODE);
    }
    else{
        throw new Exception("token incorrect", 11);
    }

}

/**
 * Cette methode permet de recuperer la liste des élèves jouant à une activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $idADM L'id de l'activite du moment
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function getElevesADM($token,$idADM,$db){
    $id = $db->GetId($token);

    if($id > 0){
        $stm = $db->getElevesADM($idADM);
        echo json_encode(array("resultat" => $stm), JSON_UNESCAPED_UNICODE);
    }
    else{
        throw new Exception("token incorrect", 11);
    }
}
