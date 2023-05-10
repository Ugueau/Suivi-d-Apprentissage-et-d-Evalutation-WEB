/**
 * Cette fonction permet de recupérer dynamiquement la liste des membres du personnel dont le nom correspond a key_word, cette requette sert pour
 * les zones de recherche
 */
function recherchePersonnel() {

    let key_word = document.querySelector("[name=recherche]").value;
    let IMESelected = document.querySelector("[name=listeIME]").value;
    let roleSelected = document.querySelector("[name=listeRole]").value;

    $.ajax({
        type: "POST",
        url: "/directeur/ajax/ListePersonnel",
        data: {
            key_word: key_word,
            IMESelected: IMESelected,
            roleSelected: roleSelected
        },
        success: function (response) {
            $("#ListePersonnel").html(response);
        },
    });
}