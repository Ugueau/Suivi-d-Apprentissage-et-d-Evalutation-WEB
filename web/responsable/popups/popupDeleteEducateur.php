<section id="popupDeleteEducateur" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Validation</h3>
        <a href="#" onclick="popNoActive('popupDeleteEducateur')"><span class="close_window"></span></a>
    </div>
    <div class="popup_content">
        <p>Êtes-vous sur de vouloir supprimer le compte de cet éducateur ?</p>
        <div class="flex_row flex_double_center popup_content space_around">
            <form action="/responsable/traitement/traitementSuppEducateur" method="post">
                <input type="hidden" name="idEducateur" id="idEducateur">
                <input type="hidden" name="idIME" id="idIME" value=<?=  $_SESSION["personne"]["id"] ?>>
                <button class="button_style_2" type="submit"> Oui </button>
                <button class="button_style_2" onclick="popNoActive('popupDeleteEducateur')" type="reset"> Non </button>
            </form>
        </div>
    </div>
</section>