function setIME(id) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "choose",
            personne: id,
            name_session: "ime_selected"
        },
        success: function (response) {
            updateImeList();
        }
    });
}
function setIdEducateur(idEducateur){
    document.getElementById("idEducateur").value = idEducateur;
}

function fill_fields(modify = true, id = null, nom = null, prenom = null, ime = null, type = null) {
    let input_id = document.getElementById("input_id_to_modify");
    let input_nom = document.getElementById("nom_educateur");
    let input_prenom = document.getElementById("prenom_educateur");
    let input_type = document.getElementById("type");
    let input_is_modify = document.getElementById("isModify");
    let ajout_educateur_title = document.getElementById("ajout_educateur_title");
    let valider_ajout_educateur = document.getElementById("valider_ajout_educateur");
    let regeneratePassword = document.getElementById("regeneratePassword");

    modify ? regeneratePassword.classList.remove('inactive') : regeneratePassword.classList.add('inactive');

    ajout_educateur_title.textContent = !modify ? "Création d'une personne" : "Modification d'une personne";
    valider_ajout_educateur.textContent = !modify ? "Créer" : "Modifier";

    modify ? input_is_modify.value = "1" : input_is_modify.value = "0";
    id !== null ? input_id.value = id : input_id.value = "-1";
    nom !== null ? input_nom.value = nom : input_nom.value = "";
    prenom !== null ? input_prenom.value = prenom : input_prenom.value = "";
    type !== null ? input_type.value = type : input_type.value = "";
    if(ime !== null) setIME(ime); else setIME(-1);
}