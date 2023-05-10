var EleveSearchString = "";

function rechercher_eleve(str) {
    EleveSearchString = str;
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/suggesteleve",
        data: {
            q: str,
        },
        success: function (response) {
            $("#outputeleve").html(response);
        }
    });
}

function add_liste_eleve(eleve) {
    // Mettre à jour la variable de session PHP avec la nouvelle valeur
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "add",
            personne: eleve,
            name_session: "liste_eleve_selected"
        },
        success: function (response) {
            rechercher_eleve(EleveSearchString);
        }
    });
}

function remove_liste_eleve(eleve) {
    // Mettre à jour la variable de session PHP avec la nouvelle valeur
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "remove",
            personne: eleve,
            name_session: "liste_eleve_selected"
        },
        success: function (response) {
            rechercher_eleve(EleveSearchString);
        }
    });
}

function update_Eleve() {
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/Listeeleve",
        success: function (response) {
            $("#eleve").html(response);
        }
    });
}