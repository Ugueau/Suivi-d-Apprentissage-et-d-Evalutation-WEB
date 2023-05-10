<?php

/** @var Database $db */
/** @var ArrayObject $Personne */

$stmt = $db->query("select idIME from Responsable where idPersonne = :idIME", array("idIME" => $Personne["id"]));
$IME = $stmt->fetch()->idIME;
$liste_eleve = $db->rechercherPersonne($IME, "eleve");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once __DIR__ . "/../include/head.php" ?>
</head>

<body class="scroll_div_element scrollbar_style_1">

<script src="/jsEducateur/popUp.js"></script>
<script src="/jsResponsable/ResponsableEleve.js"></script>

<?php include_once __DIR__ . "/../modules/header.php" ?>
<main>
    <div class="flex_column flex_double_center">
        <h2>Liste des Élèves</h2>
        <a href="#/" class="button_style_2" onclick="popActive('popupNewEleve')">Ajouter un élève</a>
        <div class="search_zone_style_1 margin">

            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="recherche" id="rechercher_eleve_input" class="searchbar_style_1"
                   placeholder="Rechercher">
        </div>
        <div class="collection">
            <?php
            foreach ($liste_eleve as $eleve) :
                $nom = $eleve["recherche"];
                if ($eleve["numeroHomonyme"] != 0) {
                    $nom = $nom . $eleve["numeroHomonyme"];
                }
                ?>

                <div class="collection_item_style_2 flex_row space_between">
                    <p><?= $nom ?></p>
                    <a href="#" id="delete_eleve_<?= $eleve['id'] ?>"
                       onclick="popActive('popupDeleteEleve'); SetIdEleve(<?= $eleve['id'] ?>)">
                        <span class="close_window"></span>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <?php include_once __DIR__ . "/popups/popupNewEleve.php" ?>
    <?php include_once __DIR__ . "/popups/popupDeleteEleve.php" ?>

</main>


<?php include_once __DIR__ . "/../modules/footer.php" ?>


</body>
<script src="/jsResponsable/ajaxJavaScript.js"></script>


