/**
 * Cette fonction permet de recupérer dynamiquement la liste des IME dont le nom correspond a key_word, cette requette sert pour
 * les zones de recherche
 * @param key_word Le nom de l'IME à rechercher
 */
function rechercheIME(key_word){
    $.ajax({
        type: "POST",
        url: "/directeur/ajax/ListeIME",
        data: {
            key_word: key_word
        },
        success: function(response) {
            $("#ListeIME").html(response);
        }
    });
}