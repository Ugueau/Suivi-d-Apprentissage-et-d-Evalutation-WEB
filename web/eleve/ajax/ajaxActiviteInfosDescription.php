<?php

include_once __DIR__."/../initEleve.php";

if(verify($_POST, 'description_activite')) {
    echo $_POST['description_activite'];
}