<?php
include_once __DIR__."/../include/start.php";

/** @var Database $db */
$idActuMoment=$db->rejouer($path_array[count($path_array)-1]);
header("location: /educateur/session/".$idActuMoment);