<?php
// People Array @TODO - Get from DB

// Get Query String
$q = $_POST['q'];


/** @var Database $db */
$people = $_SESSION["liste_eleve"];


if ($_SESSION["liste_eleve_selected"] == NULL) {
    $_SESSION["liste_eleve_selected"] = array();
    $peopleSelected = array();
} else {
    $peopleSelected = $_SESSION["liste_eleve_selected"];
}


$peopleRechercher = recherche($people, $q);


foreach ($peopleRechercher as $value) {
    $isChecked = false;
    foreach ($peopleSelected as $val) {
        if ($val == $value["id"]) {
            $isChecked = true;
        }
    }
    ?>
    <div id="item_<?= $value["id"] ?>" class="clickable_item flex_row flex_double_center">
        <input type='checkbox' name='Eleve[]' value='Eleve' class="inactive" id='Personne_<?= $value["id"] ?>'
               onchange='<?php if ($isChecked) { ?> remove_liste_eleve(<?= $value["id"] ?>)<?php } else { ?> add_liste_eleve(<?= $value["id"] ?>)<?php } ?>' <?php if ($isChecked) echo "checked"; ?>>
        <label for='Personne_<?= $value["id"] ?>' class="flex_row flex_double_center flex_wrap"> <span
                    class="name"> <?= $value["nom"] ?></span> <span
                    class="prenom"> <?= $value["prenom"] ?></span> <?php if ($value["numeroHomonyme"] != "0") {
                echo "<span class='numeroH'>" . $value["numeroHomonyme"] . "</span>";
            } ?></label>
    </div>
    <?php
}
