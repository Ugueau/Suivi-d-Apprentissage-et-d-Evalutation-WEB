<?php

$callbackList = array('/educateur/ajax/tableauActiviteDuMoment' => 'sendAjaxModifyCompetences();',
                      '/educateur/categories' => 'sendCategorieCompetences();',
                      '/educateur/nouvelle_activite' => 'updateCompetence();');


$path_total = "";
foreach($path_array as $p) {
    $path_total .= "/". $p;
}
$_SESSION['COMPETENCES_EXISTANTES_PATH_INFO'] = $path_total;

?>


<section id="ajouter_competence_existante" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Rechercher une compétence</h3>
        <a href="#" id="quit_popup_competence_existante" onclick="popNoActive('ajouter_competence_existante')"><span class="close_window"></span></a>
    </div>
    <div class="flex_column flex_double_center popup_content">
        <label for="recherche_competence">Nom d'une compétence :</label>
        <div class="search_zone_style_1">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="nom_competence" class="searchbar_style_1" id="recherche_competence_existante" placeholder="Rechercher"  onkeyup="updateCompetenceExistantes()">
        </div>
    </div>
    <div id="liste_competences_existantes" class="output list popup_content scrollbar_style_1 scroll_div_element scroll_div_large"></div>
    <div id="addCompCE"></div>
    <a id="valider_competences_existantes" href='#/' class="button_style_2" onclick='<?= $callbackList[$path_total] ?> popNoActive("ajouter_competence_existante");'>Valider</a>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="/jsEducateur/nouvelle_activite.js"></script>
<script> updateCompetenceExistantes(); </script>
