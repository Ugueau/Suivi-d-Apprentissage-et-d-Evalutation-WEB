<html lang="fr">
<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <title>Accueil directeur</title>
</head>
<body class="scroll_div_element scrollbar_style_1">
<?php include_once __DIR__ . "/../modules/header.php" ?>
<?php
/** @var Database $db */



/** @var ArrayObject $Personne */
?>

<main id="personnel">
    <div class="fill flex_column flex_double_center">
        <h2>Personnel</h2>
        <a href="#/" class="button_style_2" onclick="popActive('ajouter_educateur'); fill_fields(false);">Créer un Personnel</a>
        <div class="flex_row flex_double_center space_around flex_wrap">
            <div class="search_zone_style_1 margin">
                <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
                <input type="text" name="recherche" id="recherche_activite" class="searchbar_style_1" onkeyup='recherchePersonnel()' placeholder="Rechercher">
            </div>
            <select name="listeIME" onchange='recherchePersonnel(<?=json_encode($personnels)?>)' class="margin">
                <option value="" selected>Choisir un IME</option>
                <?php
                foreach ($IMEs as $IME):
                    ?>
                    <option value="<?= $IME["idIME"] ?>"><?= $IME["nom"] ?></option>
                <?php
                endforeach;
                ?>
            </select>
            <select name="listeRole" onchange='recherchePersonnel()'>
                <option value="" selected>Choisir un rôle</option>
                <option value="administrateur">Administrateur</option>
                <option value="directeur">Directeur</option>
                <option value="responsable">Responsable</option>
                <option value="educateur">Éducateur</option>
            </select>
        </div>
        <div id="ListePersonnel" class="list">
        </div>
    </div>
    <?php
    require_once __DIR__ . "/popups/confirmationSup.php";
    include_once __DIR__."/../responsable/popups/popupAjoutEducateur.php";
    ?>
</main>

<?php include_once __DIR__ . "/../modules/footer.php" ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/jsEducateur/popUp.js"></script>
<script src="/jsDirecteur/recherchePersonnel.js"></script>
<script src="/jsResponsable/ajaxJavaScript.js"></script>
<script src="/jsResponsable/accueilResp.js"></script>
<script>
    recherchePersonnel();
    updateImeList();
</script>
</body>
</html>
