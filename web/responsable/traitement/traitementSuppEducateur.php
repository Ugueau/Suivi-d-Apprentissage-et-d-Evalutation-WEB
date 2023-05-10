<?php

if(!empty($_POST["idEducateur"]) && !empty($_POST["idIME"])){
    $stm = $db->query("delete from Personne where idPersonne = :id", array('id' => $_POST["idEducateur"]));
}
header("Location: /responsable/accueil");