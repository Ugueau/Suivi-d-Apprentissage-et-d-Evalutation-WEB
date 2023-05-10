<?php

$isValid = true;

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$isModify = $_POST['isModify'] ?? '';
$idIMEToModify = $_SESSION['ime_selected']  ?? '';
$idToModify = $_POST['idToModify'] ?? '';
$return_page = $_POST['returnPage'] ?? '';
$isGeneratePassword = $_POST['isGeneratePassword'] ?? '';
$personneType = isset($Personne['type']) && $Personne['type'] === "directeur" ? $_POST['type'] : 'educateur';
if($Personne['type'] !== 'directeur') {
    $idIMEToModify = $Personne['idIMESelected'];
}
if(!isset($idIMEToModify)) {
    $isValid = false;
}
if (empty($nom) || empty($prenom) || empty($idIMEToModify)) {
    $isValid = false;
}

/** @var Database $db */
$mdp = $db->query('SELECT mdprandom() mdp')->fetch()->mdp;
$isModify = $isModify == "1";

if($isGeneratePassword) {
    $db->ModifyPassWord($idToModify, $mdp);
    $db->query('UPDATE Personne SET premiereConnexion = 1 WHERE idPersonne = :id', array('id' => $idToModify));
    generatePDF($nom, $prenom, $mdp);
    exit();
}
try {
    if ($isValid && !$isModify) {
        switch ($personneType) {
            case "educateur":
                $educateur = $db->CreateEducateur($nom, $prenom, $mdp);
                $db->query("call enseigne(:id,:idIME)", array("id" => $educateur->id, "idIME" => $idIMEToModify));
                $listeIme = $db->getIMEs();
                foreach ($listeIme as $ime) {
                    if ($ime['idIME'] == $idIMEToModify) {
                        if ($isValid) generatePDF($nom, $prenom, $mdp, $ime['nom']);
                    }
                }
                break;
            case "responsable":
                $responsable = $db->CreateResponsable($nom, $prenom, $mdp, $idIMEToModify);
                $db->query("call enseigne(:id,:idIME)", array("id" => $responsable->id, "idIME" => $idIMEToModify));
                $listeIme = $db->getIMEs();
                foreach ($listeIme as $ime) {
                    if ($ime['idIME'] == $idIMEToModify) {
                        if ($isValid) generatePDF($nom, $prenom, $mdp, $ime['nom']);
                    }
                }
                break;
            case "directeur":
                $db->CreateDirecteur($nom, $prenom, $mdp);
                if ($isValid) generatePDF($nom, $prenom, $mdp);
                break;
            default:
                $isValid = false;
        }

        if($isValid) {
            $_SESSION['errorManager']['code'] = 200;
            $_SESSION['errorManager']['message'] = "";
        }else{
            $_SESSION['errorManager']['code'] = 1000;
            $_SESSION['errorManager']['message'] = "Une erreur est survenue (".$_SESSION['errorManager']['code'].")";
        }
        $_SESSION['errorManager']['displayLocation'] = 'popupAjoutEducateur';

    } else if ($isValid && $isModify) {
        $db->modifyPersonne($idToModify, $nom, $prenom, $personneType, $idIMEToModify);
        if($isValid) {
            $_SESSION['errorManager']['code'] = 200;
            $_SESSION['errorManager']['message'] = "";
        }else{
            $_SESSION['errorManager']['code'] = 1000;
            $_SESSION['errorManager']['message'] = "Une erreur est survenue (".$_SESSION['errorManager']['code'].")";
        }
        $_SESSION['errorManager']['displayLocation'] = 'popupAjoutEducateur';
        header("Location: " . $return_page);
    }else{
        $_SESSION['errorManager']['code'] = 1000;
        $_SESSION['errorManager']['message'] = "Une erreur est survenue (".$_SESSION['errorManager']['code'].")";
        $_SESSION['errorManager']['displayLocation'] = 'popupAjoutEducateur';
        header("Location: " . $return_page);

    }
}catch (PDOException $error){
    echo $error;
    $isValid = false;
    $_SESSION['errorManager']['code'] = $error->getCode();
    $_SESSION['errorManager']['message'] = "Une erreur est survenue (".$_SESSION['errorManager']['code'].")";
    if($error->getCode() == 45000) {
        $_SESSION['errorManager']['message'] = "Une erreur est survenue (Base de données)";
        $sqlError = explode(" ", explode(":", $error->getMessage())[2])[1];
        if($sqlError == 30007 || $sqlError == 30006) {
            $_SESSION['errorManager']['code'] = $sqlError;
            $_SESSION['errorManager']['message'] = "Cette personne est le dernier responsable pour un IME";
        }
    }
    $_SESSION['errorManager']['displayLocation'] = 'popupAjoutEducateur';
    header("Location: ".$return_page);
}