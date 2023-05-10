<?php
/** @var ArrayObject $path_array */
switch ($path_array[1]){
    case "accueil":
        if($_SERVER["REQUEST_METHOD"]==="GET"){
            require_once __DIR__."/directeur/accueil.php";
        }else {
            if(!empty($_POST["editIME"])){
                require_once __DIR__."/directeur/traitements/add_update_IME.php";
            }if(!empty($_POST["sup"])){
                require_once __DIR__."/directeur/traitements/sup_IME.php";
            }
        }
        break;
    case "personnel":
        if($_SERVER["REQUEST_METHOD"]==="GET"){
            require_once __DIR__."/directeur/personnel.php";
        }else {
            if(!empty($_POST["editPersonnel"])){
                //require_once __DIR__."/directeur/traitements/add_update_IME.php";
            }elseif (!empty($_POST["sup"])){
                require_once __DIR__."/directeur/traitements/sup_personel.php";
            }
        }

        break;
    case "ajax":
        switch ($path_array[2]){
            case "ListeIME":
                require_once __DIR__."/directeur/ajax/ListeIME.php";
                break;
            case "ListePersonnel":
                require_once __DIR__."/directeur/ajax/ListePersonnel.php";
                break;
        }
        break;
}