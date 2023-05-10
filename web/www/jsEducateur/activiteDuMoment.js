/**
 * Cette fonction permet de mettre a jour et/ou supprimer dynamiquement un ou plusieurs champs de la table activite du moment en fonction de l'id de l'utilisateur a enlever
 * @param Remove l'id de la personne servant a la condition de remove
 */
function ajaxTableauActiviteDuMoment(Remove=0) {
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/tableauActiviteDuMoment",
        data: (Remove != 0) ? {Remove: Remove} : {},
        success: function(response) {
            $('#tableauAjax').html(response);
        }
    });
}

/**
 * Cette fonction permet de mettre a jour les champs relatif aux notes d'un eleve en fonciton des informations entrées dans un input
 * @param stringId l'id de l'élève à modifier
 */
function updateSlide(stringId){
    let input = document.getElementById("note_" + stringId);
    let p = document.getElementById("value_" + stringId);
    let check = document.getElementById("non_note_" + stringId);
    check.checked=false;
    p.innerText=input.value;
}

/**
 * Cette fonction permet de modifier le resultat d'une personne sur une competence, si l'eleve etait non-noté il recoit la note se trouvant dans l'input de sa note,
 * sinon il devient non-noté.
 * @param idPersonne L'id de l'eleve
 * @param idComp L'id de la competence concerné
 * @constructor
 */
function ChangeNonNoter(idPersonne,idComp){
    let check = document.getElementById("non_note_" + idPersonne+"_"+idComp);
    let input = document.getElementById("note_" + idPersonne+"_"+idComp);
    let p = document.getElementById("value_" + idPersonne+"_"+idComp);
    if(check.checked){
        input.disabled=true;
        p.innerText="-";
    }
    else{
        input.disabled=false;
        p.innerText=input.value;
    }
}

function valide() {
    UpdateActiviteDuMomentAddEleve(function() {
        ajaxTableauActiviteDuMoment();
    });
}

/**
 * Cette fonction permet de mettre a jour la liste des competence d'une activite du moment (Session)
 */
function ajaxTableauActiviteDuMomentComp() {
    $.ajax({
        type: "POST",
        url: "/educateur/ajax/tableauActiviteDuMoment",
        success: function (response) {
            $("#tableauAjax").html(response);
        }
    });
}

/**
 * Cette fonction permet de mettre à jour l'affichage en fonction de l'état des checkbox de notation d'une competence d'un eleve
 * @param idStudent L'id de l'etudiant dont l'affichage doit etre mis à jour
 */
function displayCompToEvaluate(idStudent){
    const input = document.getElementById("idStudent_"+idStudent);
    const comp = document.getElementById("comp_of_student_"+idStudent);
    if (input.checked == true) {
        comp.classList.remove("inactive");
        comp.classList.add("active");
    }
    else{
        comp.classList.remove("active");
        comp.classList.add("inactive");
    }
}

function returnSession(){
    if (confirm("si vous quittez sans enregistrer, vous perdrez vos données. Voulez-vous vraiment quitter ?")) {
        location.replace("/educateur/accueil")
    } else {
        txt = "You pressed Cancel!";
    }
}


