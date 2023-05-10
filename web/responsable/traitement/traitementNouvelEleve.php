<?php

if(!empty($_POST["nom_eleve"]) && !empty($_POST["prenom_eleve"])){

    /** @var Database $db */
    $stm = $db->query("SELECT idIME FROM Responsable where idPersonne = :idPersonne", array('idPersonne' => $_SESSION["personne"]["id"]));
    $idIME = $stm->fetch()->idIME;

    $stm = $db->query("select mdprandom() mdp", array());
    $mdp = $stm->fetch()->mdp;

    $id = $db->CreateEleve($_POST["nom_eleve"], $_POST["prenom_eleve"], $mdp);

    $db->query("call insertEtudie(:idIME, :idEleve)", array("idIME" => $idIME, "idEleve" => $id->id));
    generatePDF($_POST["nom_eleve"], $_POST["prenom_eleve"], $mdp, null, true);
}else {
    header("Location: /responsable/eleves");
}