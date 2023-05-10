<html lang="fr">
<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <title>Accueil Directeur</title>
</head>
<body>
<?php include_once __DIR__ . "/../modules/header.php" ?>
<?php
/** @var Database $db */
$liste_ime = $db->getIMEs();
?>

<main id="page_educateur_eleve" class="flex_column flex_double_center">
    <section id="global_educateur_eleve_section" class="flex_column flex_double_center">
        <section class="flex_column flex_double_center fill_width block_style_2">
            <label id="rechercher_eleve_label" for="rechercher_eleve_input">Rechercher un IME : </label>
            <div class="search_zone_style_1">
                <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
                <input id="rechercher_eleve_input" name="recherche_eleve" class="searchbar_style_1" size="45"
                       onkeyup='rechercheIME(this.value)' placeholder="Rechercher">
            </div>
        </section>
        <section id="ListeIME" class="flex_row flex_wrap fill space_around flex_double_center">



        </section>
        <a class="button_style_2" onclick="popActive('editIME'); init_edit_ime(0,'','')" href="#/" id="IMEID_NEW">
            Créer un IME
        </a>
    </section>

    <?php
    require_once __DIR__ . "/popups/editIME.php";
    require_once __DIR__ . "/popups/confirmationSup.php";
    ?>

</main>

<?php include_once __DIR__ . "/../modules/footer.php" ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/jsEducateur/popUp.js"></script>
<script src="/jsDirecteur/rechercheIME.js"></script>
<script>rechercheIME("")</script>
</body>
</html>