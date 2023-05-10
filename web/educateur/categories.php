<?php
/** @var Database $db */
$categorieList = $db->query("select * from Categorie where idIME = :idIME_", array("idIME_" => $Personne["idIMESelected"]));
echo $_SESSION["error"];
$_SESSION['listeCompetences'] = array();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <title>Activités</title>
</head>

<body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php"; ?>
    <main id="page_educateur_categories">
        <script src="/jsEducateur/categorie.js"></script>
        <div class="flex_row flex_double_center fill flex_wrap space_around">
            <a href="#" class="button_style_5 <?php echo $Personne["type"]=="responsable"?"active":"inactive";?>" onclick='popActive("ajouter_nouvelle_categorie");'>Créer une nouvelle Catégorie</a>
            <a id="bouton_nouvelle_competence" href="#" class="button_style_2 <?php echo $Personne["type"]=="responsable"?"inactive":"active";?>" onclick='popActive("ajouter_nouvelle_competence");'>Créer une nouvelle Compétence</a>
        </div>
        <?php include_once __DIR__ . "/popups/popupNouvelleCompetence.php";
        if($Personne["type"] == "responsable"){include_once __DIR__ . "/../responsable/popups/popupNouvelleCategorie.php";}
        ?>
        <div class="list">
            <?php
            $result = $categorieList->fetchAll();
            foreach ($result as $categorie) :
                $competenceList = $db->query("select Categorie.idCategorie, Categorie.nom, Categorie.description, Categorie.idIME, Competence.idCompetence, Competence.nom, Competence.description from Categorie natural join competenceCategorie  join Competence on competenceCategorie.idCompetence = Competence.idCompetence where Categorie.idCategorie = :idCat", array("idCat" => $categorie->idCategorie));
            ?>
            <div class="list_item_style_1 list">
                <input type="checkbox" id="idCat_<?= $categorie->idCategorie ?>" class="comp_checkbox" onchange="displayComp(<?= $categorie->idCategorie ?>)">
                <label for="idCat_<?= $categorie->idCategorie ?>" class="list_item_style_1 fill_width">
                    <div class="flex_row space_between">
                        <div class="flex_column">
                            <h2><?= $categorie->nom ?></h2>
                            <?php
                            $nbCompetences = $db->query("select idCategorie, count(idCompetence) nbComp from competenceCategorie where idCategorie = :idCat;", array("idCat" => $categorie->idCategorie));
                            $nbComp = $nbCompetences->fetch();
                            ?>
                            <p>Nombre de compétences : <?= $nbComp->nbComp ?></p>
                        </div>
                        <a href="#/" onclick="popActive('ajouter_competence_existante'); setCategorieToAdd(<?= $categorie->idCategorie ?>)" class="button_style_4 flex_column flex_double_center">+</a>
                    </div>
                </label>
                <div id="comp_from_<?= $categorie->idCategorie ?>" class="list inactive">
                    <?php
                    foreach ($competenceList as $competence) :
                    ?>
                        <section class="list_item_style_2 flex_row space_between">
                            <div class="flex_column">
                                <h4><?= $competence->nom ?></h4>
                                <p><?= $competence->description ?></p>
                            </div>
                            <a href="#" onclick='deleteCompetenceFromCategorie(<?= $categorie->idCategorie ?>, <?= $competence->idCompetence ?>);'><span class="close_window"></span></a>
                        </section>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endforeach ?>
        </div>
        <?php
        include_once __DIR__ . "/popups/popupCompetencesExistantes.php";
        include_once __DIR__ . "/popups/popupNouvelleCompetence.php";
        include_once __DIR__ . "/popups/popupRechercheCategorie.php";
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <div id="ajaxPageCategorie"></div> <!-- AJAX DIV -->
        <script src="/jsEducateur/popUp.js"></script>
        <script src="/jsEducateur/nouvelle_activite.js"></script>
    </main>
    <?php
    include_once __DIR__ . "/../modules/footer.php";
    ?>