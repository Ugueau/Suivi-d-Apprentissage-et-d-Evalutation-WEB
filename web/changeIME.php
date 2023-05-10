<?php

if(!empty($_GET["IME"])){
    $_SESSION['personne']["idIMESelected"]=$_GET["IME"];
}
header("location: /educateur/accueil");