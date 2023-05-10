<?php
/*************************
 * LOCAL
 *
 *
 *
 * *************************/
$path=explode("?",$_SERVER["REQUEST_URI"]??"/");
$path_array=explode("/",$path[0]);
$path= $path[0];

/*************************
 * LOCAL
 *
 *
 *************************/




/***********************************
 * OVH
 *
 *
$path=$_GET["url"];
$path_array=explode("/",$path);
$path = $path;
 * */
/***********************************
 * OVH
 *
 *
 ***********************************/

array_shift($path_array);

ob_start();
session_start();

require_once __DIR__ . "/include/function.php";
require_once __DIR__ . "/include/config.php";
require_once __DIR__ . "/class/Database.php";


$db = new DataBase();


if(isset($_SESSION['personne'])){
    $Personne = $_SESSION['personne'];
}
else{
    if($path_array[0]!="" and $path_array[0]!="login" and $path_array[0]!="insertion" and $path_array[0]!="api" and $path_array[0]!="CGU"and $path_array[0]!="PPD"and $path_array[0]!="APK" ){
        header("Location: /login");
    }
}


switch ($path_array[0]){
    /*
     * General
     */
    case "":
    case "login":
        if($_SERVER["REQUEST_METHOD"]==="GET"){
            require_once __DIR__."/login.php";
        }
        else{
            if(isset($_POST["FistCo"]) and $_POST["FistCo"]){
                require_once __DIR__."/newMdpConnect.php";
            }
            else{
                require_once __DIR__."/connect.php";
            }
        }
        break;
    case "newMdp":
        require_once __DIR__."/newMdp.php";
        break;
    case "api":
        require_once __DIR__."/api.php";
        break;
    /*
     * General
     */

    case 'insertion':
        require_once __DIR__."/insertion_production.php";
        break;


    /*
    * Responsable
    */
    case "responsable":
        require_once __DIR__."/appResponsable.php";
        break;
        /*
         * Educateur
         */
    case "educateur":
        require_once __DIR__."/appEducateur.php";
        break;
    /*
     * Educateur
     */

    /*
     * eleve
     */
    case "eleve":
        require_once __DIR__."/appEleve.php";
        break;
    /*
    * eleve
    */
    /*
     * directeur
     */
    case "directeur":
        require_once __DIR__."/appDirecteur.php";
        break;
    /*
    * directeur
    */


    /*
    * Outil
    */
    case "deconnexion":
        require_once __DIR__."/disconnect2.php";
        break;
    case "changeIME":
        require_once __DIR__."/changeIME.php";
        break;
    /*
    * Outil
    */
    case "traitementChangementType":
        require_once  __DIR__."/traitementChangementType.php";
        break;
    case "setting":
        require_once __DIR__."/setting.php";
        break;
    case "removeUser":
        require_once __DIR__."/removeUser.php";
        break;
    case "CGU":
        require_once __DIR__."/CGU.php";
        break;
    case "PPD":
        require_once __DIR__."/PPD.php";
        break;
    case "SESSION":
        require_once __DIR__."/ajaxSession.php";
        break;
    case "APK":
        require_once __DIR__."/APK/apk.php";
        break;


    default:
        header("HTTP/1.0 404 Not Found");
        echo "erreur 404";
        break;
}


$context = ob_get_clean();
echo $context;