<html lang="fr">
<head>
    <?php include __DIR__."/../include/head.php" ?>
    <title>Accueil responsable</title>
</head>
<body class="scroll_div_element scrollbar_style_1">
<?php include_once __DIR__."/../modules/header.php" ?>

<main >
    <section class='flex_column flex_double_center fill_width'>
        <h2>Liste des éducateurs</h2>
        <a href="#/" class='button_style_2' onclick="popActive('ajouter_educateur'); fill_fields(false);">Ajouter un éducateur</a>

        <div class="search_zone_style_1 margin">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="recherche" id="educateur_search_input" class="searchbar_style_1" onkeyup='updateEducateurList()' placeholder="Rechercher">
        </div>
        <div id='responsable_educateur_list' class="list"></div>
    </section>
    <?php
        include_once __DIR__."/popups/popupAjoutEducateur.php";
        include_once __DIR__ . "/popups/popupDeleteEducateur.php";
    ?>
</main>
<?php include_once __DIR__."/../modules/footer.php" ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="/jsResponsable/ajaxJavaScript.js"></script>
<script src="/jsResponsable/accueilResp.js"></script>
<script src="/jsEducateur/popUp.js"></script>
<script> updateEducateurList(); updateImeList(); </script>

</body>
</html>