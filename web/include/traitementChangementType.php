<?php
/** @var ArrayObject $Personne */
$_SESSION["personne"]["type"] = $Personne["type"] == "educateur" ? "responsable" : "educateur";
$type = $_SESSION["personne"]["type"];
include_once "initNav.php";
$Personne["type"] = $Personne["type"] == "educateur" ? "responsable" : "educateur";
header("Location: /".$Personne["type"]."/accueil");
