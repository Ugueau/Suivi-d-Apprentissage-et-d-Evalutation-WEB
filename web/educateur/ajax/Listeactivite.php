<?php
$liste_activite = $_SESSION["liste_activite"];
$activite_selected = $_SESSION["activite_selected"];

if (!empty($liste_activite) and !empty($activite_selected)) {
    foreach ($liste_activite as $activite) {
        if ($activite_selected == $activite["idActivite"]) {
            $act = $activite;
        }
    }
    ?>
    <label for="Activite"> <?= $act["nom"] ?> </label>
    <input type="hidden" id="custId" name="Activite" value="<?= $act["idActivite"] ?>">
    <?php
} else {
    ?>
    <span id="activite">Choix d'une Activité</span>
    <?php
}

?>

