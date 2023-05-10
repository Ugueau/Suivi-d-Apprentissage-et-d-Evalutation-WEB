var EducateurSearchString = "";

function rechercher_educateur(str) {
    EducateurSearchString = str;
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/suggesteducateur",
        data: {
            q: str,
        },
        success: function (response) {
            $("#outputeducateur").html(response);
        }
    });
}

function add_liste_educateur(educateur) {
    // Mettre à jour la variable de session PHP avec la nouvelle valeur
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "add",
            personne: educateur,
            name_session: "liste_educateur_selected"
        },
        success: function (response) {
            // Appeler la fonction AJAX pour rafraîchir la page
            rechercher_educateur(EducateurSearchString);
        }
    });
}

function remove_liste_educateur(educateur) {
    // Mettre à jour la variable de session PHP avec la nouvelle valeur
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "remove",
            personne: educateur,
            name_session: "liste_educateur_selected"
        },
        success: function (response) {
            // Appeler la fonction AJAX pour rafraîchir la page
            rechercher_educateur(EducateurSearchString);
        }
    });
}

function update_educateur() {
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/Listeeducateur",
        success: function (response) {
            $("#educateur").html(response);
        }
    });
}