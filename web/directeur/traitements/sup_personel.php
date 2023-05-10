<?php
if($Personne["type"]=="directeur"){
    /** @var Database $db */
    $db->DeletePersonnel($_POST["idSup"]);
}
header("location: /directeur/personnel");