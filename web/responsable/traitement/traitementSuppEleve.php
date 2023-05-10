<?php

if(!empty($_POST["idEleve"]) && !empty($_POST["idIME"])){

    /** @var Database $db */
    $stm = $db->query("select EleveInIME(:idEleve, :idIME) result", array("idEleve" => $_POST["idEleve"], "idIME" => $_POST["idIME"]));
    $result = $stm->fetch();

    if($result->result == 1){
        $stm = $db->query("delete from Personne where idPersonne = :id", array('id' => $_POST["idEleve"]));
    }
}
header("Location: /responsable/eleves");