<?php
//permet de mettre en SESSION au parametre $_POST['name_session'] mais en fonction du type
if (isset($_POST['personne'], $_POST['type'], $_POST['name_session'])) {
    $liste_selected = $_SESSION[$_POST['name_session']];
    switch ($_POST['type']) {
        case "add":
            $liste_selected[] = $_POST['personne'];
            break;
        case "choose":
            $liste_selected = $_POST['personne'];
            break;
        case "remove":
            foreach ($liste_selected as $i => $personne) {
                if ($personne == $_POST['personne']) {
                    unset($liste_selected[$i]);
                    break; // Sortir de la boucle après la suppression
                }
            }
            break;
    }
    $_SESSION[$_POST['name_session']] = $liste_selected;
}