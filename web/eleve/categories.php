<?php
include_once __DIR__ . "/initEleve.php";

$listeEleve = array();

$isEducateurView = false;
$eleveId = -1;
$current_IME = $Personne['idIMESelected'];
$personne;

if (verify($_POST, "eleveId")) {
    $eleveId = intval($_POST["eleveId"]);
} else {
    $eleveId = intval($Personne['id']);
}
$eleve = $db->getEleve($eleveId, $current_IME);

if (verify($_POST, "type")) {
    if ($_POST["type"] === 'educateurView') {
        $isEducateurView = true;
    }
}

$categorieList = $db->getCategories($Personne["idIMESelected"]);

?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <?php include __DIR__ . "/../include/head.php" ?>
        <title>Categories</title>
    </head>
<body class="scroll_div_element scrollbar_style_1">
<?php include_once __DIR__ . "/../modules/header.php" ?>
    <main id="page_educateur_categories" class="flex_column flex_double_center">
        <?php
        if ($isEducateurView) {
            include_once __DIR__ . "/eleveHeader.php";
        }
        ?>
        <div id="eleveCategoriesList" class="list">
            <?php
            foreach ($categorieList as $categorie) :
                $competenceList = $db->getCompetencesOfCategorie($categorie['idCategorie']);
                $moyenneCategorie = 0;
                $nbResultats = 0;
                $histogramDataArray = array();
                foreach ($competenceList as $competence) {
                    $resultats = $db->getResultatsByCompetence($eleveId, $competence['idCompetence']);
                    $nbResultats += count($resultats);
                    $nbResultats2 = count($resultats);
                    $moyenne = 0;
                    if (count($resultats) > 0) {
                        foreach ($resultats as $r) {
                            $r['note'] = intval($r['note']);
                            if ($r['note'] != -1) {
                                $moyenneCategorie += $r['note'];
                                $moyenne += $r['note'];
                            } else {
                                $nbResultats--;
                                $nbResultats2--;
                            }
                        }
                        if ($nbResultats2 > 0) {
                            $moyenne = (float)($moyenne) / $nbResultats2;
                            $tmp = array($competence['nom'], $moyenne, "#000000");
                            array_push($histogramDataArray, $tmp);
                        }
                    }
                }

                $moyenneCategorie = (float)($moyenneCategorie) / ($nbResultats == 0 ? 1 : $nbResultats);
                ?>
                <label for="idCat_<?= $categorie['idCategorie'] ?>" class="list_item_style_1">
                    <section id="eleveCategorieListCat" class="list_item_style_1 flex_row flex_wrap">
                        <h2><?= $categorie['nom'] ?></h2>
                        <div class="flex_column flex_wrap space_between">
                        <p>Nombre de compétence : <strong><?= count($competenceList) ?></strong></p>
                        <p id='moyenneCategorie_<?= $categorie['idCategorie'] ?>'>
                            Moyenne: <strong><?= round($moyenneCategorie * 100) / 100 ?>/100</strong></p>
                        </div>
                    </section>
                </label>
                <input type="checkbox" id="idCat_<?= $categorie['idCategorie'] ?>" class="comp_checkbox"
                       onchange='displayComp(<?= $categorie["idCategorie"] ?>);'>
                <div id="comp_from_<?= $categorie['idCategorie'] ?>" class="inactive list">
                    <div class="flex_row space_around graphique_competence_div">
                        <a href="#/" onclick='displayCompetences(<?= $categorie["idCategorie"] ?>);'>Compétences</a>
                        <a href="#/"
                           onclick='displayGraphiques(<?= $categorie["idCategorie"] ?>); drawHistogram("histogram_div_<?= $categorie["idCategorie"] ?>", <?= json_encode($histogramDataArray) ?>);'>Graphique</a>
                    </div>
                    <div id="competence_graphique_div_<?= $categorie['idCategorie'] ?>" class="competence_list_ajax">
                        <div id='competence_div_<?= $categorie["idCategorie"] ?>'
                             class='flex_column flex_double_center'>
                            <?php
                            foreach ($competenceList as $competence) :
                                $resultats = $db->getResultatsByCompetence($eleveId, $competence['idCompetence']);
                                $nbResultats = count($resultats);
                                $moyenne = 0;
                                if ($nbResultats > 0) {
                                    foreach ($resultats as $r) {
                                        $r['note'] = intval($r['note']);
                                        if ($r['note'] != -1) {
                                            $moyenne += $r['note'];
                                        } else {
                                            $nbResultats--;
                                        }
                                    }
                                    $moyenne = (float)($moyenne) / ($nbResultats == 0 ? 1 : $nbResultats);
                                }
                                ?>
                                <div class="list_item_style_1 fill_width flex_row space_between">
                                    <h4><?= $competence['nom'] ?></h4>
                                    <!--                                        <p>-->
                                    <?php //= $competence['description']
                                    ?><!--</p>-->
                                    <p><?php if ($nbResultats === 0) echo 'Non noté'; else echo 'Moyenne: <strong>' . (round($moyenne * 100) / 100) . '/100</strong>'; ?></p>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                        <div id='graphique_div_<?= $categorie["idCategorie"] ?>' class="inactive competenceGraphique">
                            <div id='histogram_div_<?= $categorie["idCategorie"] ?>'></div>
                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <script src="/jsEleve/graphiqueManager.js"></script>

                        </div>
                    </div>
                </div>

            <?php
            endforeach;
            ?>
        </div>
        </div>
        <script src="/jsEleve/categories.js"></script>
    </main>
<?php include_once __DIR__ . "/../modules/footer.php" ?>