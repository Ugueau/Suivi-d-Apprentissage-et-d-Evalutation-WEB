<?php


$q = $_POST['q'];

$liste_activite = $_SESSION["liste_activite"];

//on creer la liste si elle n'existe pas
if ($_SESSION["activite_selected"] == NULL) {
    $_SESSION["activite_selected"] = array();
    $activite_selected = array();
} else {
    $activite_selected = $_SESSION["activite_selected"];
}


$liste_activite = recherche($liste_activite, $q);


foreach ($liste_activite as $activite) {
    $isChecked = false;
    if (isset($activite_selected) && $activite_selected == $activite["idActivite"]) {
        $isChecked = true;
    }


    ?>
    <div class="clickable_item flex_row flex_double_center">
        <input type='radio' name='Eleve[]' value='Eleve' id='Activite_<?= $activite["idActivite"] ?>' class='inactive'
               onchange='choose_activite(<?= $activite["idActivite"] ?>)' <?php if ($isChecked) echo "checked"; ?>>
        <label for='Activite_<?= $activite["idActivite"] ?>' class="flex_column flex_double_center">
            <span><h5><?= $activite["nom"] ?></h5></span>
            <span class="text_ellipsis text_center"> <?= $activite["description"] ?></span>
        </label>
    </div>
    <?php
}