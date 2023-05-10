<?php
/** @var Database $db */
$db->DeletePersonnel($Personne["id"]);
header("location: /deconnexion");