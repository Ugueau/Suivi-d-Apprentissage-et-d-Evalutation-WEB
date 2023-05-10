<?php

/** @var ArrayObject $path_array */
switch ($path_array[1]) {

    case 'accueil':
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["changeType"])) {
            require_once __DIR__.'/educateur/accueil.php';
        }
        else{
            require_once __DIR__.'/responsable/accueil.php';
        }
        break;
    case "categories":
        require_once __DIR__ . '/responsable/categories.php';
        break;
    case "ajax":
        switch ($path_array[2]){
            case "listeEducateurs":
                require_once __DIR__."/responsable/ajax/listeEducateurs.php";
                break;
            case "listeIMEs":
                require_once  __DIR__."/responsable/ajax/listeIME.php";
                break;
        }
        break;
    case "traitement":
        switch ($path_array[2]) {
            case "traitementNewEducResp":
                require_once __DIR__."/responsable/traitement/traitementNewEducResp.php";
                break;
            case "traitementSuppEducateur":
                require_once __DIR__ . "/responsable/traitement/traitementSuppEducateur.php";
                break;
        }
    case 'eleves':
        require_once __DIR__.'/responsable/eleve.php';
        break;
    case "traitementNouvelleCategorie":
        require_once __DIR__."/responsable/traitement/traitementNouvelleCategorie.php";
        break;

    case 'traitementSuppEleve':
        require_once __DIR__ . "/responsable/traitement/traitementSuppEleve.php";
        break;

    case 'traitementNouvelEleve':
        require_once __DIR__ . "/responsable/traitement/traitementNouvelEleve.php";
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "erreur 404";
        break;
}
