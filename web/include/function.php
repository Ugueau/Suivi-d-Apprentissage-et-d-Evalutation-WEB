<?php
/**
 * Cette fonction sert a verifier si un ou plusieurs éléments du tableau possède la chaine de caractère passé en parametre
 * @param $tableau Le tableau dans lequel on effectue la recherche
 * @param $cherche l'élément recherché
 * @return array|mixed
 */
function recherche($tableau,$cherche){
    if($cherche==""){
        return $tableau;
    }
    $newTab = array();
    foreach($tableau as $val){
        if(strstr(strtoupper($val["recherche"]),strtoupper($cherche))){
            array_push($newTab,$val);
        }
    }
    return $newTab;
}

/* ######################################################
#########################################################
#########################################################*/

/**
 * Cette fonction permet de récupérer les messages associés à une erreur
 * @return string|void
 */
function getError()
{
    if (isset($_SESSION['error'])) {
        switch ($_SESSION['error']) {
            case 1:
                return "Nom d'utilisateur incorrect"; // Nom d'utilisateur incorrect
                break;
            case 2:
                return "Vous n'êtes pas encore inscrit, cliquez sur 'première connexion'";
                break;
            case 3:
                return "Mot de passe incorrect"; // Mot de passe incorrect
                break;
            case 4:
                return "Format nom d'utilisateur incorrect"; // Format nom d'utilisateur incorrect
                break;
            case 5:
                return "Vous êtes déjà inscrit, cliquez sur 'se connecter'";
                break;
            case 6:
                return "Nom, prénom ou code incorrect";
                break;
            case 7:
                return "Éducateur, Élève ou Activité non sélectionné";
                break;
        }
    }
}

/**
 * Cette fonction permet de récupérer le nom de la page à afficher dans le header depuis l'URL split au "/"
 * @param $path_all le tableau des différents éléments de l'URL
 * @return mixed|string
 */
function getPage($path){

    $pageTitle=$path;
    if(strstr($path, "accueil")){
        $pageTitle = "Accueil";
    }
    else if(strstr($path, "eleves")){
        $pageTitle = "Élèves";
    }
    else if(strstr($path, "activites")){
        $pageTitle = "Activités";
    }
    else if(strstr($path, "nouvelle_activite")){
        $pageTitle = "Nouvelle Activité";
    }
    else if(strstr($path, "categories")){
        $pageTitle = "Catégories";
    }
    else if(strstr($path, "session")){
        $pageTitle = "Session";
    }
    else if(strstr($path, "personnel")){
        $pageTitle = "Gestion du Personnel";
    }
    else if(strstr($path, "setting")){
        $pageTitle = "Paramètres";
    }
    else if(strstr($path, "CGU")){
        $pageTitle = "Conditions Générales d'Utilisation";
    }
    else if(strstr($path, "PPD")){
        $pageTitle = "Politique de Protection des Données";
    }


    return $pageTitle;
}

/**
 * Cette fonction permet de récuperer les nom, prenom et numero homonyme depuis un login
 * @param $nom Le retour du nom
 * @param $prenom Le retour du prenom
 * @param $numero Le retour du numero homonyme
 * @param $login Le login a passer en paramettre
 * @return bool
 */
function traitementConnexion(&$nom, &$prenom, &$numero, $login)
{
    $nom = "";
    $prenom = "";
    $numero = 0;
    $cpt = 0;
    $pattern = "/^([^.]){1,50}\.([^.]){1,50}$/i";

    if (preg_match_all($pattern, $login)) {
        for ($i = 0; $i < strlen($login); $i++) {
            if (!strcmp($login[$i], ".")) {
                $cpt++;
            } else {
                if (ord($login[$i]) <= 57 and ord($login[$i]) >= 48) {
                    $numero = $numero . $login[$i];
                } elseif ($cpt == 0) {

                    $nom = $nom . $login[$i];
                } else {
                    $prenom = $prenom . $login[$i];
                }
            }
        }
        return true;
    } else {
        return false;
    }

    
}

/**
 * Cette fonction permet de verifier si les cases du calendrier des détails des résultats doivent être grisées
 * @param $calendrier_type_ Le type d'affichage du calendrier
 * @param $selectedDate_ La date selectionné
 * @param $today_ La date du jour
 * @param $i L'indice de la case cliqué
 * @return bool
 */
function displayCase($calendrier_type_, $selectedDate_, $today_, $i) {

    if($calendrier_type_ == "Année") {
        if($i == 2022) {
            return true;
        }
    }
    if(intval($selectedDate_->format("Y")) < 2022) {
        return false;
    }
    if(intval($selectedDate_->format("Y")) > intval($today_->format("Y"))) {
        return false;
    }
    if(intval($selectedDate_->format("Y")) == intval($today_->format("Y"))) {
        if($calendrier_type_ == "Année") {
            if($i == 2022) {
                return true;
            }
            if(intval($today_->format("Y")) < $i) {
                return false;
            }
        }
        if($calendrier_type_ == "Mois") {
            if(intval($selectedDate_->format("m")) < $i) {
                return false;
            }
        }

        if(intval($selectedDate_->format("m")) > intval($today_->format("m"))) {
            return false;
        }
        if(intval($selectedDate_->format("m")) == intval($today_->format("m"))) {
            if($calendrier_type_ == "Jour" && $i > intval($today_->format("d"))) {
                return false;
            }
        }
    }
    return true;
}