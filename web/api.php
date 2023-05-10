<?php
include "API_procedure/functionAdd.php";
include "API_procedure/functionGet.php";

header("Access-Control-Allow-Origine: *");
header("Content-Type: application/json");

/** @var Database $db */

if (!empty($path_array)) {
    $url = $path_array;
    array_shift($url);
    try {
        //echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
        switch ($url[0]) {
            case "add":
                if (!empty($url[1])) {
                    switch ($url[1]) {
                        case "eleve":
                            echo "AddEleve";
                            break;
                        case "educateur":
                            echo "AddEducateur";
                            break;
                        case "directeur":
                            echo "AddDirecteur";
                            break;
                        case "responsable":
                            echo "AddResponsable";
                            break;
                        case "activite":
                            if (!empty($_POST["token"]) and !empty($_POST["nom"]) and !empty($_POST["desc"]) and !empty($_POST["idIME"]) and !empty($_POST["ListeIdCompetences"])) {
                                //echo json_encode(array("idADM" => "AELDDDDDDDD"), JSON_UNESCAPED_UNICODE);

                                NewActivite($_POST["token"], $_POST["nom"], $_POST["desc"], $_POST["idIME"], $_POST["ListeIdCompetences"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["nom"]) and !empty($_GET["desc"]) and !empty($_GET["idIME"]) and !empty($_GET["ListeIdCompetences"])) {
                                //echo json_encode(array("idADM" => "AELDDDDDDDD"), JSON_UNESCAPED_UNICODE);

                                NewActivite($_GET["token"], $_GET["nom"], $_GET["desc"], $_GET["idIME"], $_GET["ListeIdCompetences"], $db);
                            } else throw new Exception("un champ est vide", 15);
                            break;
                        case "activiteDuMoment":
                            //echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
                            if (!empty($_POST["token"]) and !empty($_POST["eleves"]) and !empty($_POST["educateurs"]) and !empty($_POST["idActivite"])) {
                                //echo json_encode(array("idADM" => "AELDDDDDDDD"), JSON_UNESCAPED_UNICODE);
                                addactiviteDuMoment($_POST["token"], $_POST["eleves"], $_POST["educateurs"], $_POST["idActivite"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["eleves"]) and !empty($_GET["educateurs"]) and !empty($_GET["idActivite"])) {
                                //echo json_encode(array("idADM" => "AELDDDDDDDD"), JSON_UNESCAPED_UNICODE);
                                addactiviteDuMoment($_GET["token"], $_GET["eleves"], $_GET["educateurs"], $_GET["idActivite"], $db);
                            } else throw new Exception("un champ est vide", 15);
                            break;
                        case "rejouerActiviteDuMoment":
                            if (!empty($_POST["token"]) and !empty($_POST["idADM"])) {
                                $idSender = $db->GetId($_POST["token"]);
                                if ($idSender > 0) {
                                    $idActuMoment = $db->rejouer($_POST["idADM"]);
                                    echo json_encode(array("idADM" => $idActuMoment), JSON_UNESCAPED_UNICODE);
                                } else {
                                    throw new Exception("token incorrect", 11);
                                }
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idADM"])) {
                                $idSender = $db->GetId($_GET["token"]);
                                if ($idSender > 0) {
                                    $idActuMoment = $db->rejouer($_GET["idADM"]);
                                    echo json_encode(array("idADM" => $idActuMoment), JSON_UNESCAPED_UNICODE);
                                } else {
                                    throw new Exception("token incorrect", 11);
                                }
                            } else {
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "EleveActiviteDuMoment":
                            //echo json_encode(array("ALED"=>"ALED"), JSON_UNESCAPED_UNICODE);
                            if (!empty($_POST["token"]) and !empty($_POST["eleves"]) and !empty($_POST["idADM"])) {
                                //echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
                                ModifyEleveActiviteDuMoment($_POST["token"], $_POST["eleves"], $_POST["idADM"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["eleves"]) and !empty($_GET["idADM"])) {
                                //echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
                                ModifyEleveActiviteDuMoment($_GET["token"], $_GET["eleves"], $_GET["idADM"], $db);
                            } else throw new Exception("un champ est vide", 15);
                            break;
                        case "createModifyResultat":
                            if (!empty($_POST["token"]) and !empty($_POST["idPersonne_idCompetence_valeur"]) and !empty($_POST["idADM"])) {
                                createModifyResultat($_POST["token"], $_POST["idPersonne_idCompetence_valeur"], $_POST["idADM"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idPersonne_idCompetence_valeur"]) and !empty($_GET["idADM"])) {
                                createModifyResultat($_GET["token"], $_GET["idPersonne_idCompetence_valeur"], $_GET["idADM"], $db);
                            }  else throw new Exception("un champ est vide", 15);
                            break;
                        case "competence":
                            if (!empty($_POST["token"]) && !empty($_POST["nom"]) && !empty($_POST["description"]) && !empty($_POST["listeCategorie"])) {
                                addNewCompetence($_POST["token"], $_POST["nom"], $_POST["description"], $_POST["listeCategorie"], $db);
                            }elseif (!empty($_GET["token"]) && !empty($_GET["nom"]) && !empty($_GET["description"]) && !empty($_GET["listeCategorie"])) {
                                addNewCompetence($_GET["token"], $_GET["nom"], $_GET["description"], $_GET["listeCategorie"], $db);
                            } else throw new Exception("un champ est vide", 15);
                            break;
                        default:
                            throw new Exception("cette url n'est pas valide", 10);
                            break;
                    }
                } else {
                    throw new Exception("cette url n'est pas valide", 10);
                    break;
                }
                break;
            case "modify":
                if (!empty($url[1])) {
                    switch ($url[1]) {
                        case "CompActiviteDuMoment":
                            if (!empty($_POST["token"]) and !empty($_POST["idADM"]) and !empty($_POST["ListeIdCompetences"])) {
                                //echo json_encode(array("resultat" => $_POST), JSON_UNESCAPED_UNICODE);
                                modifyActiviteDuMomentAPI($_POST["token"], $_POST["idADM"], $_POST["ListeIdCompetences"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idADM"]) and !empty($_GET["ListeIdCompetences"])) {
                                //echo json_encode(array("resultat" => $_POST), JSON_UNESCAPED_UNICODE);
                                modifyActiviteDuMomentAPI($_GET["token"], $_GET["idADM"], $_GET["ListeIdCompetences"], $db);
                            } else {
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "Activite":
                            if (!empty($_POST["token"]) and !empty($_POST["idAct"]) and !empty($_POST["nom"]) and !empty($_POST["desc"]) and !empty($_POST["ListeIdCompetences"])) {
                                //echo json_encode(array("resultat" => $_POST), JSON_UNESCAPED_UNICODE);
                                ModifyActivite($_POST["token"], $_POST["idAct"], $_POST["nom"], $_POST["desc"], $_POST["ListeIdCompetences"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idAct"]) and !empty($_GET["nom"]) and !empty($_GET["desc"]) and !empty($_GET["ListeIdCompetences"])) {
                                //echo json_encode(array("resultat" => $_POST), JSON_UNESCAPED_UNICODE);
                                ModifyActivite($_GET["token"], $_GET["idAct"], $_GET["nom"], $_GET["desc"], $_GET["ListeIdCompetences"], $db);
                            } else {
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "Competence":
                            if(!empty($_POST["token"]) && !empty($_POST["id"]) && !empty($_POST["nom"]) && !empty($_POST["description"])){
                                modifyCompetence($_POST["token"], $_POST["id"] , $_POST["nom"],$_POST["description"], $db);
                            }elseif(!empty($_GET["token"]) && !empty($_GET["id"]) && !empty($_GET["nom"]) && !empty($_GET["description"])){
                                modifyCompetence($_GET["token"], $_GET["id"] , $_GET["nom"],$_GET["description"], $db);
                            }
                            else{
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "listeCategorieCompetence":
                            if(!empty($_POST["token"]) && !empty($_POST["idComp"]) && !empty($_POST["listCat"])){
                                modifieListeCategorieCompetence($_POST["token"], $_POST["idComp"], $_POST["listCat"], $db);
                            }else{
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "listeCompetenceCategorie":
                            if(!empty($_POST["token"]) && !empty($_POST["listComp"]) && !empty($_POST["idCat"])){
                                modifieListeCompetenceCategorie($_POST["token"], $_POST["idCat"], $_POST["listComp"], $db);
                            }else{
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                    }
                }
                break;
            case "get":

                if (!empty($url[1])) {
                    switch ($url[1]) {
                        case "id":
                            if (!empty($_POST["token"])) {
                                echo json_encode(array("id" => $db->GetId($_POST["token"])), JSON_UNESCAPED_UNICODE);
                            }elseif (!empty($_GET["token"])) {
                                echo json_encode(array("id" => $db->GetId($_GET["token"])), JSON_UNESCAPED_UNICODE);
                            }
                            break;
                        case "personne":
                            if (!empty($_POST["token"]) and !empty($_POST["id"])) {
                                getPersonne($_POST["id"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["id"])) {
                                getPersonne($_GET["id"], $_GET["token"], $db);
                            }
                            break;
                        case "eleves":
                            if (!empty($_POST["token"]) and !empty($_POST["idIME"])) {
                                getEleves($_POST["idIME"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idIME"])) {
                                getEleves($_GET["idIME"], $_GET["token"], $db);
                            }
                            break;
                        case "educateurs":
                            if (!empty($_POST["token"]) and !empty($_POST["idIME"])) {
                                getEducateurs($_POST["idIME"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idIME"])) {
                                getEducateurs($_GET["idIME"], $_GET["token"], $db);
                            }
                            break;
                        case "activite":
                            if (!empty($_POST["token"]) and !empty($_POST["idIME"])) {
                                getActivite($_POST["idIME"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idIME"])) {
                                getActivite($_GET["idIME"], $_GET["token"], $db);
                            }
                            break;
                        case "responsables":
                            if (!empty($_POST["token"]) and !empty($_POST["idIME"])) {
                                getResponsables($_POST["idIME"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idIME"])) {
                                getResponsables($_GET["idIME"], $_GET["token"], $db);
                            }
                            break;
                        case "historique":
                            if (!empty($_POST["token"]) and !empty($_POST["idIME"])) {
                                getHistorique($_POST["idIME"], $_POST["token"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idIME"])) {
                                getHistorique($_GET["idIME"], $_GET["token"], $db);
                            }
                            break;
                        case "competanceActivite":
                            if (!empty($_POST["token"]) and !empty($_POST["idActivite"])) {
                                //echo json_encode(array("resultat" => $_GET), JSON_UNESCAPED_UNICODE);
                                getCompetanceActivite($_POST["token"], $_POST["idActivite"], $db);
                            }elseif (!empty($_GET["token"]) and !empty($_GET["idActivite"])) {
                                //echo json_encode(array("resultat" => $_GET), JSON_UNESCAPED_UNICODE);
                                getCompetanceActivite($_GET["token"], $_GET["idActivite"], $db);
                            } else {
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "activiteDuMoment":
                            switch ($url[2]) {
                                case "resultat":
                                    if (!empty($_POST["token"]) and !empty($_POST["idActiviteDuMoment"])) {
                                        getActiciteDuMomentResultat($_POST["idActiviteDuMoment"], $_POST["token"], $db);
                                    }elseif (!empty($_GET["token"]) and !empty($_GET["idActiviteDuMoment"])) {
                                        getActiciteDuMomentResultat($_GET["idActiviteDuMoment"], $_GET["token"], $db);
                                    }
                                    break;
                                case "competance":
                                    if (!empty($_POST["token"]) and !empty($_POST["idActiviteDuMoment"])) {
                                        getActiciteDuMomentCompetance($_POST["idActiviteDuMoment"], $_POST["token"], $db);
                                    }elseif (!empty($_GET["token"]) and !empty($_GET["idActiviteDuMoment"])) {
                                        getActiciteDuMomentCompetance($_GET["idActiviteDuMoment"], $_GET["token"], $db);
                                    }
                                    break;
                                case "eleves":
                                    if (!empty($_POST["token"]) and !empty($_POST["idActiviteDuMoment"])) {
                                        getElevesADM($_POST["token"],$_POST["idActiviteDuMoment"], $db);
                                    }elseif (!empty($_GET["token"]) and !empty($_GET["idActiviteDuMoment"])) {
                                        getElevesADM($_GET["token"],$_GET["idActiviteDuMoment"], $db);
                                    }
                                    break;
                            }
                            break;
                        case "competenceCategorie":
                            if (!empty($_POST["token"]) && !empty($_POST["idIME"])) {
                                getModelCompetenceCategorie($_POST["token"], $_POST["idIME"], $db);
                            }elseif (!empty($_GET["token"]) && !empty($_GET["idIME"])) {
                                getModelCompetenceCategorie($_GET["token"], $_GET["idIME"], $db);
                            }  else {
                                throw new Exception("un champ est vide", 15);
                            }
                            break;
                        case "getActivitesPlayed":
                            if (!empty($_POST["token"]) && !empty($_POST["idEleve"]) && !empty($_POST["start_date"]) && !empty($_POST["end_date"])) {
                                getActivitesPlayedAPI($_POST["token"], $db, $_POST["idEleve"], $_POST["start_date"], $_POST["end_date"]);
                            } elseif (!empty($_POST["token"]) && !empty($_POST["idEleve"])) {
                                getActivitesPlayedAPI($_POST["token"], $db, $_POST["idEleve"]);
                            }elseif (!empty($_GET["token"]) && !empty($_GET["idEleve"]) && !empty($_GET["start_date"]) && !empty($_GET["end_date"])) {
                                getActivitesPlayedAPI($_GET["token"], $db, $_GET["idEleve"], $_GET["start_date"], $_GET["end_date"]);
                            }elseif (!empty($_GET["token"]) && !empty($_GET["idEleve"])) {
                                getActivitesPlayedAPI($_GET["token"], $db, $_GET["idEleve"]);
                            } else {
                                throw new Exception("un champ est vide", 15);
                            }

                            break;
                        case"versionApplication":
                            echo json_encode(array("resultat" => $db->VersionApplication()), JSON_UNESCAPED_UNICODE);
                            break;

                        default:
                            throw new Exception("cette url n'est pas valide", 10);
                            break;
                    }
                } else {
                    throw new Exception("cette url n'est pas valide", 10);
                }
                break;
            case "connect":
                if (!empty($_POST["login"]) and !empty($_POST["mdp"])) {
                    getConnexion($_POST["login"], $_POST["mdp"], $db);
                }
                else if (!empty($_GET["login"]) and !empty($_GET["mdp"])){
                    getConnexion($_GET["login"], $_GET["mdp"], $db);
                }
                break;
            default:
                throw new Exception("cette url n'est pas valide", 10);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(array("error" => $e->getCode(), "message" => $e->getMessage()), JSON_UNESCAPED_UNICODE);
    }
} else {
    header("location: /login.php");
}
