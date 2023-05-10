<div id="activite_info" class="flex_column flex_double_center popup_init popup_style_1 inactive">
    <div class="flex_row popup_title">
        <h3 id="activiteInfos_nom"></h3> <!-- AJAX h2 -->
        <a id="quit_popup_activite_info" href="#/" class="button_style_3" onclick='display_element("activite_info", false)'><span class="close_window"></span></a>
    </div>

    <div class="flex_column flex_double_center popup_content">
        <span><b>Description :</b> </span>
        <p id="activiteInfos_description"></p> <!-- AJAX p -->
    </div>
    <div id="liste_competence_resultat" class="flex_column scrollbar_style_1 scroll_div_element popup_content scroll_div_element scroll_div_small"></div> <!-- AJAX div -->
</div>