/**
 * Cette fonction permet de rechercher de manière dynamique des eleves dans une liste
 * @param key_word La chaine de caractère contenant le nom et/ou prenom de l'élève
 * @param Listerechercher La liste des élèves dans laquel s'effectu la recherche
 */
function rechercheEleves(key_word,Listerechercher){
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/ListeEleves",
        data: {
            key_word: key_word,
            Listerechercher: Listerechercher
        },
        success: function(response) {
            $("#ListeEleve").html(response);
        }
    });
}