function displayComp(idCat){
    const input = document.getElementById("idCat_"+idCat);
    const comp = document.getElementById("comp_from_"+idCat);
    if (input.checked == true) {
        comp.classList.remove("inactive");
        comp.classList.add("active");
    }
    else{
        comp.classList.remove("active");
        comp.classList.add("inactive");
    }
}

/**
 * Cette fonction permet de supprimer une competence d'une categorie (suppression seulement dans la table competenceCategorie)
 * @param idCategorie
 * @param idCompetence
 */
function deleteCompetenceFromCategorie(idCategorie, idCompetence) {
    $.ajax({
        type: "POST",
        url: "ajax/CategorieDeleteCompetence",
        data: { idCategorie: idCategorie, idCompetence: idCompetence },
        success: function(response) {
            $("#ajaxPageCategorie").html(response);
        }
    });
    location.reload(true);
}