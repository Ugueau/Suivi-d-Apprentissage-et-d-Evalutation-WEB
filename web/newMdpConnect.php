<?php

if(isset($_POST["code"]) and isset($_POST["nom"]) and isset($_POST["Prenom"]) ){
/*
    $firstConnexion->bindParam(':code', $_POST["code"], PDO::PARAM_STR, 30);
    $firstConnexion->bindParam(':nom', $_POST["nom"], PDO::PARAM_STR, 50);
    $firstConnexion->bindParam(':prenom', $_POST["Prenom"], PDO::PARAM_STR, 50);
    $firstConnexion->execute();
    $recipes = $firstConnexion->fetchAll();
    foreach($recipes as $key => $value){
        $id= $value["resultat"];
    }
*/
    /** @var Database $db */
    $id =$db->VerifFirstConnect($_POST["nom"],$_POST["Prenom"],$_POST["code"]);
    
    switch($id) {
        case -2:
            $_SESSION['error'] = 5;
            $_SESSION['First'] = true;
            header("Location: login");
            break;
        case -1:
            $_SESSION['error'] = 6;
            $_SESSION['First'] = true;
            header("Location: login");
            break;
        default:
            //$Personne = new Personne($id,$_POST["nom"],$_POST["Prenom"]);
            $tmp = $db->getNumeroHomonymeFirstCo($_POST["nom"],$_POST["Prenom"],$_POST["code"]);
            $_SESSION['personne'] = array(  "id"=>$id,
                                            "nom"=>$_POST["nom"],
                                            "prenom"=>$_POST["Prenom"],
                                            "numeroHomonyme"=>$tmp
                                        );
            $_SESSION['error'] = 0;
            header("Location: newMdp");
            break;
      }
    
}