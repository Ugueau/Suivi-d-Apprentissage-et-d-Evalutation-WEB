<?php
/** @var Database $db */
$result = $db->getCompetences($Personne["idIMESelected"]);

$competenceList = [];
// if ($_SERVER["PHP_SELF"] == "/educateur/ajax/tableauActiviteDuMoment.php") {
//     $competenceList = $db->getCompetencesADM($Personne["idIMESelected"],$_SESSION["idActiviteDuMoment"]);
// }else{
    $competenceList = $result;
// }
$skillsToHide = [];

$hideSkills = false;
if($_SESSION['COMPETENCES_EXISTANTES_PATH_INFO'] == "/educateur/categories") {
    $hideSkills = true;
    $compOfCat = $db->getCompetencesOfCategorie($_SESSION['idCategorieToModify']);
    foreach ($compOfCat as $coc) {
        array_push($skillsToHide, $coc['idCompetence']);
    }
}

if(isset($_POST['data'])) {
    if(json_decode($_POST['data'], true) != "display_all") {
        $competenceList = recherche($competenceList, json_decode($_POST['data'], true));
    }
}

foreach ($competenceList as $value) :
    if (isset($value)) {
        if($hideSkills) {
            if(in_array($value['idCompetence'], $skillsToHide)) {
                continue;
            }
        }

?>
            <div class="clickable_item flex_row flex_double_center">
                <input type='checkbox' class="inactive" onchange='<?php if(isset($_SESSION['listeCompetences'])) echo in_array($value['idCompetence'], $_SESSION['listeCompetences']) ? 'removeCompetenceExistante('.$value["idCompetence"].')' : 'addCompetenceExistante('.$value["idCompetence"].');'; else echo 'addCompetenceExistante('.$value["idCompetence"].');'; ?>' id='CES_<?= $value['idCompetence'] ?>' <?php if(isset($_SESSION['listeCompetences'])) echo in_array($value['idCompetence'], $_SESSION['listeCompetences']) ? 'checked' : '' ?>>
                <label class="flex_row flex_double_center flex_wrap" for='CES_<?= $value['idCompetence'] ?>'> <span> <?= $value['nom'] ?> </span> </label>
            </div>
<?php
    }
endforeach;
?>