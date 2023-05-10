<form action="#" method="post" id="editIME" class="inactive popup_init popup_style_1 flex_column flex_double_center form_style_1">
    <div class="flex_row popup_title">
        <h3>IME</h3>
        <a href="#" onclick="popNoActive('editIME')"><span class="close_window"></span></a>
    </div>
    <label for="name">Nom</label>
    <input type="text" name="name" id="name">

    <label for="adresse">Adresse</label>
    <textarea name="adresse" id="adresse" cols="30" rows="10"></textarea>

    <input type="hidden" id="idIME" name="idIME" value="">
    <input type="hidden" id="editIME" name="editIME" value="editIME">

    <input class="button_style_2" type="submit" value="Appliquer">
</form>
