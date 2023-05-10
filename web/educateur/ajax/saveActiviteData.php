<?php
if(isset($_POST['nomActivite']) && isset($_POST['descActivite'])  && isset($_POST['isModifyActivity']) && isset($_POST['idActiviteToModify'])) {
    $_SESSION['ActiviteData']['refreshData'] = true;
    $_SESSION['ActiviteData']['nom'] = $_POST['nomActivite'];
    $_SESSION['ActiviteData']['description'] = $_POST['descActivite'];
    $_SESSION['ActiviteData']['listeCompetence'] = $_SESSION['listeCompetences'];
    $_SESSION['ActiviteData']['isModifyActivity'] = $_POST['isModifyActivity'] == "true" ? true : false;
    $_SESSION['ActiviteData']['idActiviteToModify'] = $_POST['idActiviteToModify'];
}