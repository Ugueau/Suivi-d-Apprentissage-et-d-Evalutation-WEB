<?php
if($Personne["type"]=="directeur"){
    /** @var Database $db */
    $db->DeleteIME($_POST["idSup"]);
}
header("location: /directeur/accueil");