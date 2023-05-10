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

function setMoyenne(idCategorie, moyenne) {
    const element = document.getElementById("moyenneCategorie_" + String(idCategorie));
    element.textContent = "Moyenne: " + moyenne + "/100";
}

function displayCompetences(idCategorie) {
    const competencesDiv = document.getElementById("competence_div_" + idCategorie);
    competencesDiv.classList.remove("inactive");
    const graphiqueDiv = document.getElementById("graphique_div_" + idCategorie);
    graphiqueDiv.classList.add("inactive");    
}

function displayGraphiques(idCategorie) {
    const competencesDiv = document.getElementById("competence_div_" + idCategorie);
    competencesDiv.classList.add("inactive");
    const graphiqueDiv = document.getElementById("graphique_div_" + idCategorie);
    graphiqueDiv.classList.remove("inactive"); 
}