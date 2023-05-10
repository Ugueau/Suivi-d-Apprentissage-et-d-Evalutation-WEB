<?php

// creation des IME
echo "test";
/** @var Database $db */

//creation des personnes
if($db->isInstalationProd()){
    $db->CreateDirecteur("admin", "admin", "admin");//0
    echo "Si vous voyez ca c'est que tout marche bien";
}
