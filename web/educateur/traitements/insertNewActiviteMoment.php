<?php

if(!empty($_POST["Activite"]) and !empty($_POST["Eleve"]) and !empty($_POST["Educateur"])){
    /** @var Database $db */
    $idActuMoment=$db->CreateActiviteDuMoment($_POST["Activite"], $_POST["Eleve"], $_POST["Educateur"]);
    header("location: /educateur/session/".$idActuMoment);
    exit;
}
else{
    $_SESSION["error"] = 7;
    header("location: /educateur/accueil");
}