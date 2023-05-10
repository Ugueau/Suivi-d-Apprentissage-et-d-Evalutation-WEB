<?php

function isValid($element_name, $fields = [])//element_name ne sert a rien pour le moment mais si un jour on veut faire un modify il sera utile (ref fichier traitementNouvelleActivite) #hugo
{
    // if(isset($_POST[$element_name]))
    //  if($_POST[$element_name] == "1")
    if (count($fields) == 0) {
        return true;
    } else {
        foreach ($fields as $field)
            if (!isset($_POST[$field])) if (empty($_POST[$field])) return false;
        return true;
    }
    return false;
}
if (isValid('', ['nom_competence', 'description_competence'])) {
    /** @var Database $db */
    $db->createCompetence($_POST['nom_competence'], $_POST['description_competence'], $_SESSION['listeCategories']);
}
else{
    $_SESSION["error"] = "Certain champs sont vides";
}


if (isset($_POST['return_page'])) {
    $return_page = $_POST['return_page'];
}

header("Location: ".$return_page);
