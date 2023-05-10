<?php
// People Array @TODO - Get from DB

// Get Query String
$q = $_POST['q'];


/** @var Database $db */
$liste_educateur = $_SESSION["liste_educateur"];
if ($_SESSION["liste_educateur_selected"] == NULL) {
    $_SESSION["liste_educateur_selected"] = array();
    $liste_educateur_selected = array();
} else {
    $liste_educateur_selected = $_SESSION["liste_educateur_selected"];
}


$liste_educateur = recherche($liste_educateur, $q);


foreach ($liste_educateur as $educateur) {
    $isChecked = false;
    foreach ($liste_educateur_selected as $educateur_selected) {
        if ($educateur_selected == $educateur["id"]) {
            $isChecked = true;
        }
    }
    ?>
    <div id="item_<?= $educateur["id"] ?>" class="clickable_item flex_row flex_double_center">
        <input type='checkbox' name='Educateur[]' value='Educateur' class="inactive"
               id='Personne_<?= $educateur["id"] ?>'
               onchange='<?php if ($isChecked) { ?> remove_liste_educateur(<?= $educateur["id"] ?>)<?php } else { ?> add_liste_educateur(<?= $educateur["id"] ?>)<?php } ?>' <?php if ($isChecked) echo "checked"; ?>>
        <label for='Personne_<?= $educateur["id"] ?>' class="flex_row flex_double_center flex_wrap"> <span
                    class="name"> <?= $educateur["nom"] ?></span> <span
                    class="prenom"> <?= $educateur["prenom"] ?></span> <?php if ($educateur["numeroHomonyme"] != "0") {
                echo "<span class='numeroH'>" . $educateur["numeroHomonyme"] . "</span>";
            } ?></label>
    </div>
    <?php
}
