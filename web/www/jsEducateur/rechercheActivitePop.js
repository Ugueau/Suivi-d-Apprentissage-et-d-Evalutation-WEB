var ActiviteSearchString = "";

function rechercher_activite(str) {
    ActiviteSearchString = str;
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/suggestactivite",
        data: {
            q: str,
        },
        success: function (response) {
            $("#outputactivite").html(response);
        }
    });
}

function choose_activite(activite) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "choose",
            personne: activite,
            name_session: "activite_selected"
        },
        success: function (response) {
            // Appeler la fonction AJAX pour rafraîchir la page
            rechercher_activite(ActiviteSearchString);

        }
    });
}

function update_activite() {
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/Listeactivite",
        success: function (response) {
            $("#activite").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Une erreur est survenue lors de la requête AJAX.");
        }
    });
}