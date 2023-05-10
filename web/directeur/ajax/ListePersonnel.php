<?php
$key_word= $_POST["key_word"];
/** @var Database $db */
$personnels = $db->getPersonnels();

$personnels = recherche($personnels, $key_word);

if ($_POST["roleSelected"] != "") {
    $newTab = array();
    foreach ($personnels as $personnel) {
        if ($personnel["type"] == $_POST["roleSelected"]) {
            array_push($newTab, $personnel);
        }
    }
    $personnels = $newTab;
}

if ($_POST["IMESelected"] != "") {
    $newTab = array();
    foreach ($personnels as $personnel) {
        $listeIME = explode(",", $personnel["ListeIME"]);
        if (!(array_search($_POST["IMESelected"], $listeIME) === false)) {
            array_push($newTab, $personnel);
        }
    }
    $personnels = $newTab;
}


/** @var Database $db */


foreach ($personnels as $personnel):
    ?>
    <div class="list_item_style_1 flex_row space_between <?= $personnel["id"] == $Personne["id"] ? "border" : ""; ?>">
        <div class="flex_row flex_wrap flex_double_center fill_width space_around">
        <span class="text_center"><?= $personnel["nom"] . " " . $personnel["prenom"]; ?><?php echo $personnel["numeroHomonyme"] > 0 ? " " . $personnel["numeroHomonyme"] : ""; ?></span>
        <span class="margin flex_row space_around">
            <?php switch ($personnel["type"]) {
                case "educateur":
                    echo "Éducateur";
                    break;
                case "directeur":
                    echo "Directeur";
                    break;
                case "administrateur":
                    echo "Administrateur";
                    break;
                case "responsable":
                    echo "Responsable";
                    break;
                default:
                    break;
            } ?>
            <?php

            $idIMEToModify = $personnel['type'] != 'directeur' ? explode(",", $personnel['ListeIME'])[0] : null;
            ?>
        </span></div>
        <div class="flex_row flex_wrap flex_double_center">
                        <a href="#/" class="button_style_3" onclick='popActive("ajouter_educateur"); fill_fields(true, "<?= $personnel['id'] ?>", "<?= $personnel['nom'] ?>", "<?= $personnel['prenom'] ?>", "<?= $idIMEToModify ?>", "<?= $personnel['type'] ?>"); <?= $idIMEToModify != null ? 'setIME('.$idIMEToModify.');' : '' ?>'>Modifier</a>
                        <a href="#/"
                           onclick="popActive('sup'); init_sup_ime(<?= $personnel["id"] ?>,'<?= $personnel["recherche"] ?>')"
                           class="button_style_3">Supprimer</a>

        </div>
    </div>
<?php
endforeach;
?>