<?php
/**
 * Cette fonction permet d'ajouter une nouvelle activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $eleves La liste des eleves a ajouter
 * @param $educateurs La liste des educateurs a ajouter
 * @param $idactivite L'activité servant de reference
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function addactiviteDuMoment($token, $eleves, $educateurs, $idactivite, $db = null)
{
    $idSender = $db->GetId($token);
    if ($idSender > 0) {
        $Tableeleves = json_decode($eleves, true);
        $Tableeducateurs = json_decode($educateurs, true);


        $TableidActuMoment = $db->CreateActiviteDuMoment($idactivite, $Tableeleves, $Tableeducateurs);
        echo json_encode(array("idADM" => $TableidActuMoment), JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de Creer/modifier les resultats d'une activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $idPersonne_idCompetence_valeur Le tableau des Resultat associé aux competences et aux eleves a inserer
 * @param $idADM L'id de l'activité du moment à modifier
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function createModifyResultat($token, $idPersonne_idCompetence_valeur, $idADM, $db = null)
{
    echo json_encode(array("resultat" => $idPersonne_idCompetence_valeur), JSON_UNESCAPED_UNICODE);
    $idSender = $db->GetId($token);
    if ($idSender > 0) {

        $table_idPersonne_idCompetence_valeur = json_decode($idPersonne_idCompetence_valeur, true);
        foreach ($table_idPersonne_idCompetence_valeur as $val) {
            $db->createModifyResultat($val["idCompetence"], $idADM, $val["idPersonne"], $val["valeur"]);
        }
        echo json_encode($idPersonne_idCompetence_valeur, JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de supprimer/ajouter un eleve d'une activite du moment
 * @param $token Le token de la personne executant la requete
 * @param $eleves L'id de l'eleve a modifier
 * @param $idADM L'id de l'activite du moment a modifier
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function ModifyEleveActiviteDuMoment($token, $eleves, $idADM, $db = null)
{
    if ($db == null) {
        throw new Exception("La base de données n'est pas définie", 12);
    }
    $id = $db->GetId($token);

    if ($id > 0) {
        $eleves = json_decode($eleves, true);
        $oldEleves = $db->getElevesADM($idADM);
        //echo json_encode(array("test"=>$oldEleves), JSON_UNESCAPED_UNICODE);
        foreach ($eleves as $e) {
            if (!in_array($e, $oldEleves)) {
                $db->Joue($e, $idADM);
            }
        }
        foreach ($oldEleves as $e) {
            if (!in_array($e, $eleves)) {
                $db->NeJouePlus($e, $idADM);
            }
        }
        echo json_encode(array("resultat" => true), JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de modifier la liste des competences d'une activité du moment
 * @param $token Le token de la personne executant la requete
 * @param $idADM L'id de l'activite du moment a modifier
 * @param $ListeIdCompetences La liste des competence à ajouter
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function modifyActiviteDuMomentAPI($token, $idADM, $ListeIdCompetences, $db)
{
    if ($db == null) {
        throw new Exception("La base de données n'est pas définie", 12);
    }
    $id = $db->GetId($token);

    if ($id > 0) {
        $ListeIdCompetences = json_decode($ListeIdCompetences, true);

        $db->modifyActiviteDuMomentFullListIdComp($idADM, $ListeIdCompetences);

        echo json_encode(array("resultat" => true), JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de créer une nouvelle competence
 * @param $token Le token de la personne executant la requete
 * @param $nom Le nom de la nouvelle competence
 * @param $desc La description de la competence
 * @param $listCat La liste des categorie dans laquelle se trouve la competence
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function addNewCompetence($token, $nom, $desc, $listCat, $db = null)
{
    $id = $db->GetId($token);

    if ($id > 0) {
        $listCatDecode = json_decode($listCat, true);
        $idComp = $db->createCompetence($nom, $desc, $listCatDecode);
        echo (json_encode(array("idNouvelleCompetence" => $idComp)));
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette fonction permet de modifier une Activite
 * @param $token Le token de la personne executant la requete
 * @param $idAct L'id de l'activite
 * @param $nom Le nouveau nom de l'activite
 * @param $desc La nouvelle description
 * @param $ListeIdCompetences La nouvelle liste de competence
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function ModifyActivite($token, $idAct, $nom, $desc, $ListeIdCompetences, $db)
{
    $id = $db->GetId($token);
    if ($id > 0) {
        $ListeIdCompetences = json_decode($ListeIdCompetences, true);
        $db->modifyActivite($idAct, $nom, $desc, $ListeIdCompetences);
        echo (json_encode(array("idActivite" => $idAct)));
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette methode permet de créer une nouvelle Activite
 * @param $token Le token de la personne executant la requete
 * @param $nom Le nom de la nouvelle a ctivite
 * @param $desc La description de la nouvelle activite
 * @param $idIME L'id de l'IME
 * @param $ListeIdCompetences La liste des competence
 * @param $db Il s'agit de l'instance de la classe Database
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function NewActivite($token, $nom, $desc, $idIME, $ListeIdCompetences, $db)
{
    $id = $db->GetId($token);
    if ($id > 0) {
        $ListeIdCompetences = json_decode($ListeIdCompetences, true);
        $db->createActivite($nom, $desc, $idIME, $ListeIdCompetences);
        echo (json_encode(array("resultat" => true)));
    } else {
        throw new Exception("token incorrect", 11);
    }
}

/**
 * @param $idComp
 * @param $listCat
 * @param $db
 * @return void affiche au format JSON le resultat
 * @throws Exception
 */
function modifieListeCategorieCompetence($token, $idComp, $listCat, $db = null)
{

    $id = $db->GetId($token);
    if ($id > 0) {
        $listCatDecode = json_decode($listCat, true);
        if (count($listCatDecode) < 1) {
            throw new Exception("une compétence doit posséder au moins une categorie", 16);
        } else {
            $db->query("delete from competenceCategorie where idCompetence = :idComp", array("idComp" => $idComp));
            foreach ($listCatDecode as $idCat) {
                $db->query("select competenceCategorie(:idComp, :idCat) as test", array("idComp" => $idComp, "idCat" => $idCat));
            }
        }
    }else{
        throw new Exception("token incorrect", 11);
    }
}

function modifieListeCompetenceCategorie($token, $idCat, $listComp, $db = null)
{

    $id = $db->GetId($token);
    if ($id > 0) {
        $listCompDecode = json_decode($listComp, true);
        if (count($listCompDecode) < 1) {
            throw new Exception("une compétence doit posséder au moins une categorie", 16);
        } else {
            $db->query("delete from competenceCategorie where idCategorie = :idCat", array("idCat" => $idCat));
            foreach ($listCompDecode as $idComp) {
                $db->query("select competenceCategorie(:idComp, :idCat) as test", array("idComp" => $idComp, "idCat" => $idCat));
            }
        }
    }else{
        throw new Exception("token incorrect", 11);
    }
}

/**
 * Cette methode de modifier une competence
 * @param $token
 * @param $idComp
 * @param $nom
 * @param $desc
 * @param $db
 * @return void affiche au format JSON le resultat
 * @throws Exception Code: 11 -> token incorrect
 */
function modifyCompetence($token, $idComp, $nom, $desc, $db = null){
    $id = $db->GetId($token);

    if ($id < 0) {
        throw new Exception("token invalide", 11);
    } else {
        $db->query("update Competence set nom = :nom where idCompetence = :idComp; update Competence set description = :desc where idCompetence = :idComp;", array("nom" => $nom, "desc" => $desc, "idComp" => $idComp));
        echo (json_encode(array("resultat" => true)));
    }
}
