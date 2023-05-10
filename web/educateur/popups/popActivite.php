<section id="popActivite" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Choix des Activité</h3>
        <a href="#" onclick="popNoActive('popActivite')"><span class="close_window"></span></a>
    </div>
    <div class="flex_column flex_double_center popup_content">
        <label for="recherche_activite">Nom d'Activité :</label>
        <?php if ($_SERVER["PHP_SELF"] == "/educateur/accueil.php") {
            $AjaxPageReturn = "Liste";
        }
            else if ($_SERVER["PHP_SELF"] == "/educateur/ajax/tableauActiviteDuMoment.php") {
                $AjaxPageReturn = "ActiviteDuMomentAssEleve";
        } ?>
        <div class="search_zone_style_1">
            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
            <input type="text" name="recherche" id="recherche_activite" class="searchbar_style_1" onkeyup='rechercher_activite(this.value, "Liste")' placeholder="Rechercher">
        </div>
    </div>
    <a href="nouvelle_activite" class="button_style_2" onclick="resetSessionsActivite()">Nouvelle Activité</a>
    <div id="outputactivite" class="output list popup_content scroll_div_large scroll_div_element scrollbar_style_1">
    </div>
    <a href="#" class="button_style_2" onclick='popNoActive("popActivite")'>Valider</a>
</section>