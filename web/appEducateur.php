<?php
/** @var ArrayObject $path_array */

switch ($path_array[1]){
    case "accueil":
        if($_SERVER["REQUEST_METHOD"]==="GET"){
            require_once __DIR__."/educateur/accueil.php";
        }else{
            if(!empty($_POST["insertNewActiviteMoment"])){
                require_once __DIR__."/educateur/traitements/insertNewActiviteMoment.php";
            }
            // Changement de rôle pour les éducateurs dans la popup de profil
            else{
                if (isset($_POST["changeType"])){
                    require_once __DIR__.'/responsable/accueil.php';
                }
                else{
                    require_once __DIR__.'/educateur/accueil.php';
                }
            }
        }
        break;
    case "session":
        if($_SERVER["REQUEST_METHOD"]==="GET") {
            require_once __DIR__ . "/educateur/session.php";
        }else{
            require_once __DIR__."/educateur/UpdateNote.php";
        }
        break;
    case "activites":
        require_once __DIR__."/educateur/activites.php";
        break;
    case "categories":
        require_once __DIR__."/educateur/categories.php";
        break;
    case "nouvelle_activite":
        if($_SERVER["REQUEST_METHOD"]==="GET") {
            require_once __DIR__ . "/educateur/nouvelle_activite.php";
        }else{
            if(isset($_POST['isModifyActivity'])) {
                if($_POST['isModifyActivity'] == "true") {
                    require_once __DIR__ . "/educateur/nouvelle_activite.php";
                    break;
                }
            }
            require_once __DIR__ . "/educateur/traitements/traitementNouvelleActivite.php";
        }
        break;
    case "eleves":
        require_once __DIR__."/educateur/eleves.php";
        break;
    case"rejouer":
        require_once __DIR__ . "/educateur/traitements/rejouer.php";
        break;

    case "traitementNouvelleCompetence":
        require_once __DIR__."/educateur/traitements/traitementNouvelleCompetence.php";
        break;


    case "ajax":
        switch ($path_array[2]){
            case "ListeEleves":
                require_once __DIR__."/educateur/ajax/ListeEleves.php";
                break;
            case "suggesteducateur":
                require_once __DIR__."/educateur/ajax/suggesteducateur.php";
                break;
            case "suggesteleve":
                require_once __DIR__."/educateur/ajax/suggesteleve.php";
                break;
            case "suggestactivite":
                require_once __DIR__."/educateur/ajax/suggestactivite.php";
                break;
            case "Listeeducateur":
                require_once __DIR__."/educateur/ajax/Listeeducateur.php";
                break;
            case "Listeeleve":
                require_once __DIR__."/educateur/ajax/Listeeleve.php";
                break;
            case "Listeactivite":
                require_once __DIR__."/educateur/ajax/Listeactivite.php";
                break;
            case "Listeeducateur":
                require_once __DIR__."/educateur/ajax/Listeeducateur.php";
                break;
            case "tableauActiviteDuMoment":
                require_once __DIR__."/educateur/ajax/tableauActiviteDuMoment.php";
                break;
            case "tableauActiviteDuMoment":
                require_once __DIR__."/educateur/ajax/tableauActiviteDuMoment.php";
                break;
            case "ActiviteDuMomentAddEleve":
                require_once __DIR__ . "/educateur/ajax/ActiviteDuMomentAddEleve.php";
                break;
            case "ActiviteDuMomentAddCompetence":
                require_once __DIR__."/educateur/ajax/ActiviteDuMomentAddCompetence.php";
            case "listeCompetences":
                require_once __DIR__."/educateur/ajax/listeCompetences.php";
                break;
            case "ActiviteDuMomentAddCompetence":
                require_once __DIR__."/educateur/ajax/ActiviteDuMomentAddCompetence.php";
                break;
            case "listeCompetencesExistantes":
                require_once __DIR__."/educateur/ajax/listeCompetencesExistantes.php";
                break;
            case "listeCategoriesExistantes":
                require_once __DIR__."/educateur/ajax/listeCategoriesExistantes.php";
                break;
            case "saveActiviteData":
                require_once __DIR__."/educateur/ajax/saveActiviteData.php";
                break;
            case "listeCategories":
                require_once __DIR__."/educateur/ajax/listeCategories.php";
                break;
            case "CategorieAddCompetence":
                require_once  __DIR__."/educateur/ajax/CategorieAddCompetence.php";
                break;
            case "resetListeCompetences":
                require_once  __DIR__."/educateur/ajax/resetListeCompetences.php";
            case "CategorieDeleteCompetence":
                require_once __DIR__."/educateur/ajax/CategorieDeleteCompetence.php";
        }


        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "erreur 404";
        break;
}