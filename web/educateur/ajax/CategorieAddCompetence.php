<?php

$listeCompetence = $_SESSION['listeCompetences'];
$idCategorie = $_POST["idCat"];

foreach($listeCompetence as $comp) {
    /** @var Database $db */
    $prep = $db->query("select competenceCategorie(:idComp,:idCat)", array('idComp' => $comp, 'idCat' => $idCategorie));
    $prep->fetch();
}