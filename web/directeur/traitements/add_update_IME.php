<?php

if($Personne["type"]=="directeur"){
    /** @var Database $db */
    if($_POST["idIME"]==0){
        $db->CreateIME($_POST["name"],$_POST["adresse"]);
    }else{
        $db->UpdateIME($_POST["idIME"],$_POST["name"],$_POST["adresse"]);
    }
}
header("location: /directeur/accueil");
