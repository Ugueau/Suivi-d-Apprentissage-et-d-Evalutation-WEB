var listeCategories = [];

document.getElementById("bouton_competence_existante").addEventListener('click', function() {
    document.getElementById('ajouter_competence_existante').classList.add("active");
    document.getElementById('ajouter_competence_existante').classList.remove("inactive");
});

document.getElementById("quit_popup_competence_existante").addEventListener('click', function() {
    document.getElementById('ajouter_competence_existante').classList.remove("active");
    document.getElementById('ajouter_competence_existante').classList.add("inactive");
});

document.getElementById("valider_competences_existantes").addEventListener('click', function() {
    document.getElementById('ajouter_competence_existante').classList.remove("active");
    document.getElementById('ajouter_competence_existante').classList.add("inactive");
    send_competence("send_ajout_activite", "1");
});

// ---- //

function send_competence(id, state) {
    let input = document.getElementById(id);
    input.value = state;
}

document.getElementById("bouton_nouvelle_competence").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.add("active");
    document.getElementById('ajouter_nouvelle_competence').classList.remove("inactive");
});

document.getElementById("quit_popup_nouvelle_competence").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.remove("active");
    document.getElementById('ajouter_nouvelle_competence').classList.add("inactive");
    send_competence("send_ajout_competence", "0");
    send_competence("send_ajout_activite", "1");
});

document.getElementById("valider_nouvelle_competence").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.remove("active");
    document.getElementById('ajouter_nouvelle_competence').classList.add("inactive");
    send_competence("send_ajout_competence", "1");
    send_competence("send_ajout_activite", "0");
});

// ---- //

document.getElementById("bouton_ajout_categorie").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.remove("active");
    document.getElementById('ajouter_nouvelle_competence').classList.add("inactive");
    document.getElementById('recherche_categorie').classList.add("active");
    document.getElementById('recherche_categorie').classList.remove("inactive");
});

document.getElementById("quit_popup_recherche_categorie").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.add("active");
    document.getElementById('ajouter_nouvelle_competence').classList.remove("inactive");
    document.getElementById('recherche_categorie').classList.remove("active");
    document.getElementById('recherche_categorie').classList.add("inactive");
});

document.getElementById("valider_categorie").addEventListener('click', function() {
    document.getElementById('ajouter_nouvelle_competence').classList.add("active");
    document.getElementById('ajouter_nouvelle_competence').classList.remove("inactive");
    document.getElementById('recherche_categorie').classList.remove("active");
    document.getElementById('recherche_categorie').classList.add("inactive");
});

// ---- GESTION COMPETENCE ----- //

function addCompetenceExistante(id) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "add",
            personne: id,
            name_session: "listeCompetences"
        },
        success: function (response) {
            updateCompetenceExistantes();
        }
    });
}

function removeCompetenceExistante(id) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "remove",
            personne: id,
            name_session: "listeCompetences"
        },
        success: function (response) {
            updateCompetenceExistantes();
        }
    });
}

function updateCompetence() {
    send_modification("competences_selectionnees", "/educateur/ajax/listeCompetences", "");
}

function updateCompetenceExistantes() {
    let search_input = document.getElementById("recherche_competence_existante");
    let search_word = search_input.value;
    send_modification("liste_competences_existantes", "/educateur/ajax/listeCompetencesExistantes", search_word);
}


function sendAjaxModifyCompetences() {
    if(confirm("Si vous validez sans enregistrer, les notes seront effacées, voulez-vous continuer ?")) {
        send_modification("addCompCE", "/educateur/ajax/ActiviteDuMomentAddCompetence", "");
        ajaxTableauActiviteDuMomentComp();
    }else{
        popNoActive('ajouter_competence_existante');
    }
} // Usage : /educateur/popup/popupCompetencesExistantes

var idCategorieToAdd = -1;

function setCategorieToAdd(id) {
    idCategorieToAdd = id;
    send_modification("ajaxPageCategorie", "/educateur/ajax/resetListeCompetences", id);
    updateCompetenceExistantes();
}

function updateRechercheCatExistantes(display_all = false) {
    send_modification("liste_categories_recherche", "/educateur/ajax/listeCategoriesExistantes", searchword)
}

function sendCategorieCompetences() {
    if(idCategorieToAdd !== -1) {
        $.ajax({
            type: 'POST',
            url: '/educateur/ajax/CategorieAddCompetence',
            data: {
                idCat: idCategorieToAdd
            },
            success: function(response) {
                $("#ajaxPageCategorie").html(response);
            }
        });
    }
    window.location.reload();
}


function saveActiviteData(isModify, idModify) {
    var nomActiviteInput = document.getElementById("nom_activite");
    var descActiviteInput = document.getElementById("description_activite");
    var nomActivite = nomActiviteInput.value;
    var descActivite = descActiviteInput.value;
    if(idModify == -1) {
        isModify = false;
    }

    send_modification_advanced("nouvelle_activite_ajax_div", "/educateur/ajax/saveActiviteData", {"isModifyActivity": isModify, "idActiviteToModify": idModify, "nomActivite": nomActivite, "descActivite": descActivite});
}


// ---- GESTION CATEGORIE ----- //

function categorieInputChange(categorie, send_ajax = true) {
    let input_clicked = document.getElementById('CATS_' + categorie['idCategorie']);
    if(input_clicked.checked){
        addCategorie(categorie, send_ajax);
    }else{
        removeCategorie(categorie, send_ajax);
    }
}

function addCategorie(categorie, send_ajax = true) {
    let input_clicked = document.getElementById('CATS_' + categorie['idCategorie']);
    input_clicked.checked = true;
    listeCategories.push(categorie);
    var labels = document.getElementsByTagName('label');
    for(let index = 0; index < labels.length; index++){
        if(labels[index].htmlFor == 'CATS_' + categorie['idCategorie']) {
            labels[index].classList.remove('checkbox_element_style_1');
            labels[index].classList.add('checkbox_checked_element_style_1');
        }
    }
    if(send_ajax) send_modification("popup_nouvelle_competences_liste_categories", "/educateur/ajax/listeCategories", listeCategories);
}

function removeCategorie(categorie, send_ajax = true) {
    let input_clicked = document.getElementById('CATS_' + categorie['idCategorie']);
    input_clicked.checked = false;
    for(let index = 0; index < listeCategories.length; index++){
        if(listeCategories[index]['idCategorie'] == categorie['idCategorie']){
            listeCategories.splice(index, 1);
        }
    }
    var labels = document.getElementsByTagName('label');
    for(let index = 0; index < labels.length; index++){
        if(labels[index].htmlFor == 'CATS_' + categorie['idCategorie']) {
            labels[index].classList.add('checkbox_element_style_1');
            labels[index].classList.remove('checkbox_checked_element_style_1');
        }
    }
    if(send_ajax) send_modification("popup_nouvelle_competences_liste_categories", "/educateur/ajax/listeCategories", listeCategories);
}

function clear_categories() {
    listeCategories = [];
    var labels = document.getElementsByTagName('label');
    for(let index = 0; index < labels.length; index++){
        if(labels[index].htmlFor == 'CATS_' + categorie['idCategorie']) {
            labels[index].classList.add('checkbox_element_style_1');
            labels[index].classList.remove('checkbox_checked_element_style_1');
        }
    }
}

function send_categories() {
    send_modification("popup_nouvelle_competences_liste_categories", "/educateur/ajax/listeCategories", listeCategories);
}

function send_ajax_competence() {
    send_modification("competences_selectionnees", "/educateur/ajax/listeCompetences", "");
}


// ---- ENVOYER LES MODIFICATIONS - AJAX ---- //

function send_modification(div_id, page_path, data) {
    $.ajax({
        type: "POST",
        url: page_path,
        data: {data: JSON.stringify(data).replace(/&apos;/g, "]#apos;")},
        success: function(response) {
            $("#" + div_id).html(response);
        }
    });
}

function send_modification_advanced(div_id, page_path, data_map) {
    $.ajax({
        type: "POST",
        url: page_path,
        data: data_map,
        success: function (response) {
            $('#' + div_id).html(response);
        }
    });
}


function resetSessionsActivite() {
    send_modification("ajax_activite_div", "resetActiviteSessions.php", "nodata");
}

function addCategorieExistante(id) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "add",
            personne: id,
            name_session: "listeCategories"
        },
        success: function (response) {
            updateCategorieExistantes();
        }
    });
}

function removeCategorieExistante(id) {
    $.ajax({
        type: "POST",
        url: "/SESSION",
        data: {
            type: "remove",
            personne: id,
            name_session: "listeCategories"
        },
        success: function (response) {
            updateCategorieExistantes();
        }
    });
}

function updateCategorie() {
    send_modification("popup_nouvelle_competences_liste_categories", "/educateur/ajax/listeCategories", "");
}

function updateCategorieExistantes() {
    var input = document.getElementById("recherche_categorie_input");
    var searchword = input.value;
    send_modification("liste_categories_recherche", "/educateur/ajax/listeCategoriesExistantes", searchword);
}