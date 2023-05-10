<form action="#" method="post" id="sup" class="inactive popup_init popup_style_1 flex_column flex_double_center confirmSupIME">
    <div class="flex_row popup_title">
        <h3>Confirmation</h3>
        <a href="#" onclick="popNoActive('sup')"><span class="close_window"></span></a>
    </div>

    <p class="margin">Confirmez-vous la suppression de : <span class="bold" id="nameIME"></span> </p>

    <input type="hidden" id="idSup" name="idSup" value="">
    <input type="hidden" id="sup" name="sup" value="sup">

    <div class="margin flex_row space_around fill_width">
        <input onclick="popNoActive('sup')" class="button_style_2" type="reset" value="annuler">
        <input class="button_style_2" type="submit" value="supprimer">
    </div>
</form>
