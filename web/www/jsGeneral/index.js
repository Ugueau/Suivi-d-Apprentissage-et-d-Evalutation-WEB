
connexion.classList.add("active");
FirstConnexion.classList.add("inactive");
popUpModifPassWord.classList.add("inactive");

function bouttonFirstConnexion(){
    document.getElementById("connexion").classList.remove("active");
    document.getElementById("connexion").classList.add("inactive");
    document.getElementById("FirstConnexion").classList.add("active");
    document.getElementById("FirstConnexion").classList.remove("inactive");
}

function bouttonConnexion(){
    document.getElementById("connexion").classList.remove("inactive");
    document.getElementById("connexion").classList.add("active");
    document.getElementById("FirstConnexion").classList.add("inactive");
    document.getElementById("FirstConnexion").classList.remove("active");
}

function manual(){
    document.getElementById("newMDP").classList.add("active");
    document.getElementById("newMDP").classList.remove("inactive");
    document.getElementById("manual").classList.add("inactive");
    document.getElementById("manual").classList.remove("active");
}/**/