<?php
/** @var TYPE_NAME $Personne */
$current_IME = $Personne["idIMESelected"];

if(!isset($_SESSION['ActiviteData']) || empty($_SESSION['ActiviteData'])) {
    $_SESSION['ActiviteData']['refreshData'] = false;
    $_SESSION['ActiviteData']['nom'] = "";
    $_SESSION['ActiviteData']['description'] = "";
    $_SESSION['ActiviteData']['listeCompetence'] = array();
    $_SESSION['listeCompetences'] = array();
    $_SESSION['ActiviteData']['isModifyActivity'] = false;
    $_SESSION['ActiviteData']['idActiviteToModify'] = -1;
}

if (isset($_POST["idActivite"]) && $_SESSION['ActiviteData']['refreshData'] === false) {
    if($_POST['idActivite'] != -1) {
        $_SESSION['ActiviteData']['isModifyActivity'] = true;
        $_SESSION['ActiviteData']['idActiviteToModify'] = $_POST["idActivite"];
    }else{
        $_SESSION['ActiviteData']['isModifyActivity'] = false;
    }
}

?>
<html lang="fr">

<head>
    <?php include_once __DIR__ . "/../include/head.php"  ?>
    <?php
    if ($_SESSION['ActiviteData']['isModifyActivity'] === false) {
        echo "<title>Nouvelle activité</title>";
    } else {
        echo "<title>Modifier une activité</title>";
        /** @var TYPE_NAME $db */
        $activity_to_modify = $db->query("SELECT * FROM Activite WHERE idActivite = :idActivite", array('idActivite' => $_SESSION['ActiviteData']['idActiviteToModify']));
        $activity_to_modify = $activity_to_modify->fetch();
    }
    ?>
</head>

<body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php" ?>
    <main id="page_educateur_nouvelle_activite" class="flex_column flex_double_center center">
        <script src="/jsEducateur/nouvelle_activite.js"></script>
        <div class="fill flex_column flex_double_center" id="nouvelle_activite">
            <form method="post" class="block_style_1 flex_column flex_double_center form_style_1">
                <?php
                if ($_SESSION['ActiviteData']['isModifyActivity'] === false) {
                    echo "<h2>Nouvelle Activité</h2>";
                } else {
                    echo "<h2>Modifier une Activité</h2>";
                }
                ?>
                <div class="flex_column flex_double_center fill_width"><!-- id="section_nom_activite" -->
                    <label for="nom_activite">Intitulé de l'activité</label>
                    <input id="nom_activite" name="nom_activite" class="input_style_1" value='<?php if($_SESSION['ActiviteData']['refreshData']) echo  $_SESSION['ActiviteData']['nom']; else if (isset($activity_to_modify)) {
                                                                                            echo $activity_to_modify->nom;
                                                                                        } ?>'>
                </div>
                <div class="flex_column flex_double_center fill_width"><!-- id="section_description_activite" -->
                    <label for="description_activite">Description de l'activité</label>
                    <textarea id="description_activite" name="description_activite" class="textarea_style_1" rows="8"><?php if($_SESSION['ActiviteData']['refreshData']) echo  $_SESSION['ActiviteData']['description']; else if (isset($activity_to_modify)) {
                                                                                                            echo $activity_to_modify->description;
                                                                                                        } ?></textarea>
                </div>
                <div class="flex_row space_around fill_width flex_wrap"><!-- id="section_gestion_competence" -->
                    <div class="flex_row">
                        <a id="bouton_competence_existante" href="#/" class="button_style_2">Ajouter une compétence existante</a>
                    </div>
                    <div class="flex_row">
                        <a id="bouton_nouvelle_competence" href="#/" class="button_style_2" onclick='saveActiviteData(<?php echo $_SESSION["ActiviteData"]["isModifyActivity"] === true ? "true" : "false"; ?>, <?= $_SESSION["ActiviteData"]["idActiviteToModify"] ?>);'>Créer une nouvelle compétence</a>
                    </div>
                </div>

                <input type="hidden" id="modify_activite" name="isModifyActivite" value="<?php if ($_SESSION['ActiviteData']['isModifyActivity'] === true) echo "1";
                                                                                            else echo "0"; ?>">
                <?php if (isset($_SESSION['ActiviteData']['idActiviteToModify'])) echo "<input type='hidden' name='idActivite' value='" . $_SESSION['ActiviteData']['idActiviteToModify'] . "'>" ?>
                <input type="hidden" id="send_ajout_activite" name="isAjoutActivite" value="<?= $_SESSION['ActiviteData']['isModifyActivity'] ? '0' : '1' ?>">
                <input type="hidden" id="idIME" name="idIME" value="<?= $current_IME ?>">
                <input type="hidden" id="return_page" name="return_page" value="<?php if($_SESSION['ActiviteData']['isModifyActivity']) echo "/educateur/activites"; else echo "/educateur/nouvelle_activite" ?>">
                <input type="hidden" id="idCompetencesList" name="idCompetencesList[]" value="">

                <div id="competences_selectionnees" class="scrollbar_style_1 flex_column"></div>

                <button id="creer_activite_button" type="submit" class="button_style_0"><?php if (!$_SESSION['ActiviteData']['isModifyActivity']) {
                                                                                            echo "Créer l'Activité";
                                                                                        } else {
                                                                                            echo "Modifier l'Activité";
                                                                                        } ?>
                
                </button>
                <p class="error_message_style_1"><?php if($_SESSION["error"] == "L'un des champs n'est pas rempli"){echo $_SESSION["error"];$_SESSION["error"]="";}else{echo "";}?></p>


            </form>

            <?php
            include_once __DIR__."/popups/popupCompetencesExistantes.php";
            include_once __DIR__."/popups/popupNouvelleCompetence.php";
            include_once __DIR__."/popups/popupRechercheCategorie.php";
            ?>

            <div id="nouvelle_activite_ajax_div"></div> <!-- AJAX DIV -->

        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/jsEducateur/nouvelle_activite.js"></script>
    <?php if($_SESSION['ActiviteData']['refreshData']) echo "<script>  send_ajax_competence(); </script>"; ?>
    <?php
    if ($_SESSION['ActiviteData']['isModifyActivity'] && !$_SESSION['ActiviteData']['refreshData']) :
        $query = $db->query("select distinct Competence.idCompetence idCompetence, Competence.nom nom from Activite
                                join competenceActivite on competenceActivite.idActivite = Activite.idActivite
                                join Competence on competenceActivite.idCompetence = Competence.idCompetence
                                join competenceCategorie on  competenceCategorie.idCompetence = Competence.idCompetence
                                join Categorie on Categorie.idCategorie = competenceCategorie.idCategorie
                                where Activite.idIME = :idIME_ and Activite.idActivite = :idAct and Activite.vers = competenceActivite.vers and competenceActivite.sous_vers = 0;", array("idIME_" => $Personne['idIMESelected'], "idAct" => $_SESSION['ActiviteData']['idActiviteToModify']));
        $result = $query->fetchAll();
        $_SESSION['listeCompetences'] = array();
        foreach ($result as $comp) :
    ?>
            <script>
                addCompetenceExistante(<?=  $comp->idCompetence ?>);
            </script>
    <?php
        endforeach;
        ?>
    <script>updateCompetence()</script>
        <?php
    endif;
     $_SESSION['ActiviteData'] = array();
    ?>
    <?php include_once __DIR__ . "/../modules/footer.php" ?>