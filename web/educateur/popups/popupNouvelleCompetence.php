<?php
$path_total = "";
foreach($path_array as $p) {
    $path_total .= "/". $p;
}
$_SESSION['listeCategories'] = array();
?>
<form method="POST" action="/educateur/traitementNouvelleCompetence" id="ajouter_nouvelle_competence" class="flex_column flex_double_center inactive popup_init popup_style_1 form_style_1">
    <div class="flex_row popup_title">
        <h3>Nouvelle compétence</h3>
        <a href="#" id="quit_popup_nouvelle_competence" onclick="popNoActive('ajouter_nouvelle_competence');"><span class="close_window"></span></a>
    </div>

    <div class="flex_column flex_double_center fill_width">
        <div class="flex_column flex_double_center fill_width">
            <label for="nom_competence">Nom de la compétence</label>
            <input id="nom_competence" name="nom_competence" class="input_style_1" size="30">
        </div>
        <div class="flex_column flex_double_center fill_width">
            <label for="description_competence">Description de la compétence</label>
            <textarea id="description_competence" name="description_competence" class="textarea_style_1" rows="8" cols="40"></textarea>
        </div>
        <div>
            <a id="bouton_ajout_categorie" class="button_style_2" href="#" onclick="popActive('recherche_categorie');">Ajouter une catégorie</a>
        </div>
    </div>
    <div id="popup_nouvelle_competences_liste_categories" class="flex_column"></div>
    <input type="hidden" id="return_page" name="return_page" value="<?= $path_total ?>">
    <button type="submit" id="valider_nouvelle_competence" class="button_style_0">Créer la Compétence</button>
    <p class="error_message_style_1"><?php if("Certain champs sont vides" == $_SESSION["error"]){echo $_SESSION["error"]; $_SESSION["error"]="";}else{echo "";}?></p>
</form>