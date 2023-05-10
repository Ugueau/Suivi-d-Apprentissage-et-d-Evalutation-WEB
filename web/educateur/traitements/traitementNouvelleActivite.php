<?php
    function isValid($element_name, $fields = []) {
        if(isset($_POST[$element_name])) {
            if($_POST[$element_name] == "1") {
                if(count($fields) == 0) {
                    return true;
                }else {
                    foreach($fields as $field) {
                        if(!isset($_POST[$field])) {
                            return false;
                        }else {
                            if(empty($_POST[$field])) return false;
                        }
                    }
                    return true;
                }
            }
            return false;
        }
        return false;
    }
    /** @var Database $db */
    if(isValid('isModifyActivite', ['nom_activite', 'description_activite', 'idCompetences', 'idActivite']))
        $db->modifyActivite($_POST['idActivite'], $_POST['nom_activite'], $_POST['description_activite'], $_POST['idCompetences']);
    else if (isValid('isAjoutActivite', ['nom_activite', 'description_activite', 'idCompetences']) && !isValid('isModifyActivite'))
        $db->createActivite($_POST['nom_activite'], $_POST['description_activite'], $_POST['idIME'], $_POST['idCompetences']);
    else{
        $_SESSION["error"] = "L'un des champs n'est pas rempli";
    }
    $_SESSION['listeCompetences'] = array();
    // le header("Location: ".$_SERVER["HTTP_REFERER"]); marche pas
    header("Location: /educateur/activites");