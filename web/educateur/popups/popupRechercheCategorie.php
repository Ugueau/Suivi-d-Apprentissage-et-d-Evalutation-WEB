<section id="recherche_categorie" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Rechercher une catégorie</h3>
        <!-- <a id="quit_popup_recherche_categorie" href="#" class="button_style_3">X</a> -->
        <a href="#" id="quit_popup_recherche_categorie" onclick="popNoActive('recherche_categorie'); clear_categories();"><span class="close_window"></span></a>
    </div>
    <div class="flex_column flex_double_center popup_content">
        <label for="recherche_categorie">Nom d'une catégorie :</label>
        <div class="search_zone_style_1">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input name="nom_categorie" class="searchbar_style_1" id="recherche_categorie_input" placeholder="Rechercher" onkeyup="updateCategorieExistantes();">
        </div>
    </div>
    <div id="liste_categories_recherche"  class="output list popup_content scroll_div_large scroll_div_element scrollbar_style_1"></div>
    <a id="valider_categorie" href='#' class="button_style_2" onclick="updateCategorie(); popNoActive('recherche_categorie');">Valider</a>
</section>
<!--
recherche
<script src="/educateur/javascript/nouvelle_activite.js"></script>
<script>updateRechercheCatExistantes(true) </script>
-->

<script src="/jsEducateur/nouvelle_activite.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script> updateCategorieExistantes(); </script>