<?php

//$connextion = $db->prepare("select connexion(:nom, :prenom, :numero,:mdp)resultat");


if (isset($_POST["username"]) and isset($_POST["password"])) {
    $login = $_POST["username"];
    $mdp = $_POST["password"];
    $nom = "";
    $prenom = "";
    $numero = 0;
    $cpt = 0;


    if (traitementConnexion($nom, $prenom, $numero, $login)) {
        /*
        $connextion->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
        $connextion->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
        $connextion->bindParam(':numero', $numero, PDO::PARAM_INT, 11);
        $connextion->bindParam(':mdp', $mdp, PDO::PARAM_STR, 30);
        $connextion->execute();
        $recipes = $connextion->fetchAll();
*/
        /** @var Database $db */
        $id = $db->VerifConnect($nom, $prenom, $numero, $mdp);
        /*
        foreach($recipes as $key => $value){
            $id= $value["resultat"];
        }
*/
        switch ($id) {
            case -3:
                $_SESSION['error'] = 3;
                break;
            case -2:
                $_SESSION['error'] = 2;
                break;
            case -1:
                $_SESSION['error'] = 1;
                break;
            default:
                $isResp = $db->query("select isResponsable(:id) iR",array('id' => $id));
                $isResp = $isResp->fetch();

                $getPersonne = $db->query("call getPersonne(:id,@nom,@prenom,@numeroH,@type,@idIME,@nomIME); select @nom nom ,@prenom prenom ,@numeroH numeroHomonyme,@type type,@idIME idIME,@nomIME nomIME", array('id' => $id));
                $getPersonne->nextRowset();
                $out = $getPersonne->fetch();
                $idIME=explode(',', $out->idIME);
                $nomIME=explode(',', $out->nomIME);

                //$Personne = new Personne($id,$out->nom,$out->prenom,$out->numeroH,$out->type,$out->idIME);
                $_SESSION['personne'] = array(
                    "id" => $id,
                    "nom" => $out->nom,
                    "prenom" => $out->prenom,
                    "numeroHomonyme" => $out->numeroHomonyme,
                    "type" => $out->type,
                    "idIMESelected" => $idIME[0],
                    "isResponsable" => $isResp->iR
                );
                $cpt = 0;
                foreach ($idIME as $val) {
                    $_SESSION['personne']["ListeIME"][$val] = array(
                        "id" => $val,
                        "nom" => $nomIME[$cpt]
                    );
                    $cpt++;
                }
                $_SESSION['error'] = 0;

                break;
        }
    } else {
        $_SESSION['error'] = 4;
    }
    if ($id <= 0) {
        header("Location: login");
        exit;
    } else {
        $type = $out->type;
        require_once __DIR__."/initNav.php";

        header("Location: " . $out->type . "/accueil");
        exit;
    }
}
