<?php
    $current_IME = $Personne["idIMESelected"];
?>
<head>
    <?php include_once __DIR__ . "/../include/head.php" ?>
</head>
<?php
/** @var Database $db */
$liste_eleve = $db->rechercherPersonne($current_IME, "eleve");
?>
<html lang="fr">
<body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php" ?>
    <main id="page_educateur_eleve" class="flex_column flex_double_center">
        <section id="global_educateur_eleve_section" class="flex_column flex_double_center">
            <section class="flex_column flex_double_center fill_width block_style_2">
                <label id="rechercher_eleve_label" for="rechercher_eleve_input">Rechercher un élève : </label>
                <div class="search_zone_style_1">
                    <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
                    <input id="rechercher_eleve_input" name="recherche_eleve" class="searchbar_style_1" size="45" onkeyup='rechercheEleves(this.value,<?=json_encode($liste_eleve)?>)'>
                </div>
            </section>
            <section id="ListeEleve" class="flex_row flex_wrap fill space_around flex_double_center">
            </section>
        </section>
    </main>
<?php include_once __DIR__ . "/../modules/footer.php" ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/jsEducateur/rechercheEleves.js"></script>
    <script>rechercheEleves("",<?=json_encode($liste_eleve)?>)</script>

</body>
</html>
