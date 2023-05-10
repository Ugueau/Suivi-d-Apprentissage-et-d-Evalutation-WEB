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
if (isValid('', ['nom_categorie', 'description_categorie'])) {
    /** @var Database $db */
    /** @var ArrayObject $Personne */
    $db->createCategorie($_POST['nom_categorie'], $_POST['description_categorie'], $Personne["idIMESelected"]);
}
else{
    $_SESSION["error"] = "Certain champs sont vides";
}

/*$return_page = '/educateur/nouvelle_activite';
if (isset($_POST['return_page'])) {
    $return_page = $_POST['return_page'];
}*/ //marche pas
header("Location: /responsable/categories");