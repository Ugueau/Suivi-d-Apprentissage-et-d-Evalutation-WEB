<?php
if($type=="eleve"){
    $nav = array("Accueil"=>"/eleve/accueil", "Catégories"=>"/eleve/categories");
    $_SESSION['nav']=$nav;
}
if($type=="educateur"){
    $nav = array("Accueil"=>"/educateur/accueil", "Élèves"=>"/educateur/eleves", "Activités"=>"/educateur/activites", "Catégories"=>"/educateur/categories");
    $_SESSION['nav']=$nav;
}
if($type=="directeur"){
    $nav = array("Accueil"=>"/directeur/accueil", "Personnel"=>"/directeur/personnel");
    $_SESSION['nav']=$nav;
}
if($type=="responsable"){
    $nav = array("Accueil"=>"/responsable/accueil", "Élèves"=>"/responsable/eleves", "Catégories"=>"/responsable/categories");
    $_SESSION['nav']=$nav;
}