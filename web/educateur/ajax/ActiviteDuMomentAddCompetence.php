<?php

$listeCompetences = $_SESSION['listeCompetences'];

if(isset($listeCompetences)) {
    /** @var Database $db */
    try {
        $db->modifyActiviteDuMoment($_SESSION["idActiviteDuMoment"], $listeCompetences);
    } catch (Exception $e) {
    }
}