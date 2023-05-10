<?php
/** @var ArrayObject $path_array */
switch ($path_array[1]){
    case "accueil":
        require_once __DIR__."/eleve/accueil.php";
        break;
    case "categories":
        require_once __DIR__."/eleve/categories.php";
        break;



    case"ajax":
        switch ($path_array[2]){
            case"ajaxCalendrier":
                require_once __DIR__."/eleve/ajax/ajaxCalendrier.php";
                break;
            case "ajaxDateSelector":
                require_once __DIR__."/eleve/ajax/ajaxDateSelector.php";
                break;
            case "ajaxActivite":
                require_once __DIR__."/eleve/ajax/ajaxActivite.php";
                break;
            case "ajaxActiviteInfosNom":
                require_once __DIR__."/eleve/ajax/ajaxActiviteInfosNom.php";
                break;
            case "ajaxActiviteInfosDescription":
                require_once __DIR__."/eleve/ajax/ajaxActiviteInfosDescription.php";
                break;
            case "ajaxActiviteInfosCompResults":
                require_once __DIR__."/eleve/ajax/ajaxActiviteInfosCompResults.php";
                break;
        }
}