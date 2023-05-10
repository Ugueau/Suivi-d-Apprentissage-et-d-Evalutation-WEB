<?php

if(isset($_POST['idCompetence']) && isset($_POST['idCategorie'])) {
    /** @var Database $db */
    $db->deleteCompetenceFromCategorie($_POST['idCategorie'], $_POST['idCompetence']);
}