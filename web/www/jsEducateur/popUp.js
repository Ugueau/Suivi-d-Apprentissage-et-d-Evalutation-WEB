/**
 * Cette fonction permet de rendre visible une popup
 * @param string L'id de la popup
 */
function popActive(string) {
    var ob = document.getElementById(string);
    ob.classList.remove("inactive");
    ob.classList.add("active");
    var labels = document.getElementsByTagName('label');
    for(let index = 0; index < labels.length; index++){
        if(labels[index].htmlFor == string) {
            labels[index].classList.remove('checkbox_element_style_1');
            labels[index].classList.add('checkbox_checked_element_style_1');
        }
    }
}

/**
 * Cette fonciton permet de rentre invisible une popup
 * @param string Lid de la popup
 */
function popNoActive(string) {
    var ob = document.getElementById(string);
    ob.classList.remove("active");
    ob.classList.add("inactive");
    var labels = document.getElementsByTagName('label');
    for(let index = 0; index < labels.length; index++){
        if(labels[index].htmlFor == string) {
            labels[index].classList.add('checkbox_element_style_1');
            labels[index].classList.remove('checkbox_checked_element_style_1');
        }
    }
}


/****************************************************************************************
 * 
 * 
 * 
 * PopUp General
 *******************************************************************************************/

function getHTMLId(Eleve,type){
    if(type=="eleve" || type=="educateur"){
        return "Personne_" + Eleve["id"];
    }
    else if(type=="activite"){
        return "Activite_" + Eleve["idActivite"];
    }

    return null;
}

let Liste = Array();


/****************************************************************************************
 * PopUp General
 * 
 * 
 * fonction pour Activiter du moment
 *******************************************************************************************/


function UpdateActiviteDuMomentCompetences(type, AjaxPageReturn) {
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            document.getElementById(AjaxPageReturn).innerHTML = this.respo
        }
    }
    xmlhttp.open("POST", "/educateur/ajax/ActiviteDuMomentAddCompetence", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`q=`+JSON.stringify(Liste["competences"][type]));
}

function addADMComp(competences, id, type) {
    let input = document.getElementById(id);
    input.checked = true;
    Liste["competences"][type].push(competences);
}

function removeADMComp(competences, id, type) {
    let input = document.getElementById(id);
    input.checked = false;
    for (let index = 0; index < Liste["competences"][type].length; index++) {
        if (Liste["competences"][type][index]["id"] == competences["id"]) {
            Liste["competences"][type].splice(index, 1);
        }
    }
}

function init_edit_ime(id,nom,adress){
    let input_name = document.getElementById("name");
    let input_adress = document.getElementById("adresse");
    let input_idIME = document.getElementById("idIME");
    input_name.value=nom;
    input_adress.value=adress;
    input_idIME.value=id;
}
function init_sup_ime(id,nom){
    let nameIME = document.getElementById("nameIME");
    let idIMESup = document.getElementById("idSup");
    nameIME.innerHTML =nom;
    idIMESup.value=id;
}


function UpdateActiviteDuMomentAddEleve(callback) {
    $.ajax({
        type: 'POST',
        url: '/educateur/ajax/ActiviteDuMomentAddEleve',
        success: function(response) {
            callback();
        }
    });
}
