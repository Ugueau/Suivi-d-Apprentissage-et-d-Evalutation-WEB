<?php
$idADM = $_POST["idADM"];

foreach ($_POST as $key => $val) {
    if (!(strrpos($key, "note_") === false)) {
        $Liste = explode("_", $key);

        $idPersonne = $Liste[1];
        $idComp = $Liste[2];

        if ($val == "on") {
            $valeur = -1;
        } else {
            $valeur = $val;
        }

        /** @var Database $db */
        $db->createModifyResultat($idComp, $idADM, $idPersonne, $valeur);
        header("location: ".$_SERVER['HTTP_REFERER']);
    }
}

