<section id="listeEleve" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Choix des Élèves</h3>
        <a href="#" onclick="popNoActive('listeEleve')"><span class="close_window"></span></a>
    </div>

    <div class="flex_column flex_double_center popup_content">
        <label for="recherche_eleve">Nom d'utilisateur :</label>
        <?php 
        if ($_SERVER["REQUEST_URI"] == "/educateur/accueil") {
            $AjaxPageReturn = "Liste";
        }
            else if ($_SERVER["REQUEST_URI"] == "/educateur/ajax/tableauActiviteDuMoment") {
                $AjaxPageReturn = "ActiviteDuMomentAssEleve";
        }
        ?>
        <div class="search_zone_style_1">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="recherche" id="recherche_eleve" class="searchbar_style_1" onkeyup='rechercher_eleve(this.value)'>
        </div>
    </div>
    <div id="outputeleve" class="output list popup_content scroll_div_large scroll_div_element scrollbar_style_1">
    </div>
    <a href="#" class="button_style_2" onclick='popNoActive("listeEleve"); <?=($_SERVER["REQUEST_URI"] == "/educateur/ajax/tableauActiviteDuMoment")?("valide(`eleve`, `".$AjaxPageReturn."`);"):("") ?>'>Valider</a>
</section>