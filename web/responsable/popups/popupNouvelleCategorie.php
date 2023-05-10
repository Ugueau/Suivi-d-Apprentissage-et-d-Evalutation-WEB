<form method="POST" action="/responsable/traitementNouvelleCategorie" id="ajouter_nouvelle_categorie" class="flex_column flex_double_center inactive popup_init popup_style_1 form_style_1">
    <div class="flex_row popup_title">
        <h3>Nouvelle Catégorie</h3>
        <a href="#" id="quit_popup_nouvelle_categorie" onclick="popNoActive('ajouter_nouvelle_categorie');"><span class="close_window"></span></a>
    </div>

    <div class="flex_column flex_double_center fill_width">
        <div class="flex_column flex_double_center fill_width">
            <label for="nom_categorie">Nom de la catégorie</label>
            <input id="nom_categorie" name="nom_categorie" class="input_style_1" size="30">
        </div>
        <div class="flex_column flex_double_center fill_width">
            <label for="description_categorie">Description de la catégorie</label>
            <textarea id="description_categorie" name="description_categorie" class="textarea_style_1" rows="8" cols="40"></textarea>
        </div>
    </div>
    <input type="hidden" id="return_page" name="return_page" value="<?= $_SERVER["PHP_SELF"] ?>">
    <button type="submit" id="valider_nouvelle_categorie" class="button_style_0">Créer la Catégorie</button>
    <p class="error_message_style_1"><?php if("Certain champs sont vides" == $_SESSION["error"]){echo $_SESSION["error"]; $_SESSION["error"]="";}else{echo "";}?></p>
</form>