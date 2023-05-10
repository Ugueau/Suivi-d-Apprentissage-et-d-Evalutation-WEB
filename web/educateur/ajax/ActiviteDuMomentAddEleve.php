<?php

$people = $_SESSION["liste_eleve_selected"];

$liste_eleve = $_SESSION["liste_eleve"];


foreach ($people as $values) {
    foreach ($liste_eleve as $val) {
        if($values==$val["id"]){
            /** @var Database $db */
            $db->query("call joue(:idPer,:idJouer)", array("idPer" => $val['id'], "idJouer" => $_SESSION["idActiviteDuMoment"]));
        }
    }
}