<?php

include_once __DIR__."/../initEleve.php";

if(verify($_POST, 'nom_activite')) {
    echo $_POST['nom_activite'];
}