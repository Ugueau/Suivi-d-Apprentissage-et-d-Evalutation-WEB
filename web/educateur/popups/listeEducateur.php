<section id="listeEducateur" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Choix des Éducateurs</h3>
        <a href="#" onclick="popNoActive('listeEducateur')"><span class="close_window"></span></a>
    </div>
    <div class="flex_column flex_double_center popup_content">
        <label for="recherche_educ">Nom d'utilisateur :</label>
        <?php 
        if ($_SERVER["PHP_SELF"] == "/educateur/accueil.php") {
            $AjaxPageReturn = "Liste";
        }
            else if ($_SERVER["PHP_SELF"] == "/educateur/ajax/tableauActiviteDuMoment.php") {
                $AjaxPageReturn = "ActiviteDuMomentAssEleve";
        } 
        ?>
        <div class="search_zone_style_1">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="recherche" id="recherche_educ" class="searchbar_style_1" onkeyup='rechercher_educateur(this.value,"Liste")'>
        </div>
    </div>
    <div id="outputeducateur" class="output list popup_content scroll_div_large scroll_div_element scrollbar_style_1">
    </div>
    <a href="#" class="button_style_2" onclick='popNoActive("listeEducateur")'>Valider</a>
</section>