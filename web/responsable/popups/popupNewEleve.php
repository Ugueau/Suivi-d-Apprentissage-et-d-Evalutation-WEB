<section id="popupNewEleve" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Nouvel Élève</h3>
        <a href="#" onclick="popNoActive('popupNewEleve'); resetChampNewEleve()"><span class="close_window"></span></a>
    </div>
    <form action="/responsable/traitementNouvelEleve" method="post" class="flex_column popup_content form_style_1">

        <label for="student_name">Nom</label>
        <input id="student_name" type="text" name="nom_eleve">
        <label for="student_firstname">Prénom</label>
        <input id="student_firstname" type="text" name="prenom_eleve">
        <button type="submit" onclick="popNoActive('popupNewEleve'); download_the_pdf()" class="button_style_2">Valider</button>
    </form>

</section>