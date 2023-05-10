<?php
/** @var Database $db */
$ListeEleveRechercher = $db->rechercherPersonne($Personne["idIMESelected"], 'eleve');

if (!empty($_POST["Remove"])) {
    /** @var Database $db */
    $db->query("DELETE FROM joue WHERE idPersonne=:idP and idActiviteDuMoment=:idA", array('idA' => $_SESSION["idActiviteDuMoment"], 'idP' => $_POST["Remove"]));
}


$Liste = array();
$ListeCompetence = array();

$activiterDuMoment = $db->query("SELECT * FROM activiterDuMoment where idActiviteDuMoment=:id", array('id' => $_SESSION["idActiviteDuMoment"]));
$activiterDuMoment = $activiterDuMoment->fetchAll();
foreach ($activiterDuMoment as $compt) {
    $Liste[$compt->idPersonne]["personne"] = array(
        "idPersonne" => $compt->idPersonne,
        "nom" => $compt->nom,
        "prenom" => $compt->prenom,
        "numeroHomnyme" => $compt->numeroHomonyme
    );
}

$competence = $db->query("SELECT * FROM competence where idActiviteDuMoment=:id", array('id' => $_SESSION["idActiviteDuMoment"]));
$competence = $competence->fetchAll();
$competenceListId = [];
foreach ($competence as $compt) {
    $competenceListId[] = $compt->idCompetence;
}

$_SESSION['listeCompetences'] = $competenceListId;

foreach ($Liste as $key => $subListe) {

    foreach ($competence as $compt) {
        $tmp = json_decode(json_encode($compt), true);

        $ListeCompetence[$compt->idCompetence] = $tmp;
        $Liste[$key]["competence"][$compt->idCompetence] = $tmp;
        $Liste[$key]["competence"][$compt->idCompetence]["note"] = -1;
    }
}

foreach ($Liste as $key => $subListe) {
    foreach ($activiterDuMoment as $compt) {
        if ($key == $compt->idPersonne) {
            if ($compt->idCompetence != NULL) {
                $Liste[$key]["competence"][$compt->idCompetence]["note"] = $compt->note;
            }
        }
    }
}
$nomAct = $db->query("Select nom from ActiviteDuMoment join Activite on Activite.idActivite = ActiviteDuMoment.idActivite where ActiviteDuMoment.idActiviteDuMoment=:id", array('id' => $_SESSION["idActiviteDuMoment"]));
$nomAct = $nomAct->fetch();
?>
    <h2><?= $nomAct->nom ?></h2>
    <form method="POST" id="form_ADM" class="fill flex_column flex_double_center">
        <div class="flex_row flex_double_center flex_wrap">
            <a href="#" onclick="returnSession();"
               class="button_style_2 flex_column flex_double_center margin"> <img id="return" src="/img/return.svg"> </a>
            <a href="#" onclick="popActive('listeEleve');rechercher_eleve('');"
               class="button_style_2 flex_column flex_double_center margin">Ajouter des élèves</a>
               <a href="#" onclick='popActive("ajouter_competence_existante");' class="button_style_2">Gérer les compétences</a>
            <button type="submit" class="button_style_0 margin">Enregister</button>
        </div>
        <datalist id="volsettings">
            <option>0</option>
            <option>10</option>
            <option>20</option>
            <option>30</option>
            <option>40</option>
            <option>50</option>
            <option>60</option>
            <option>70</option>
            <option>80</option>
            <option>90</option>
            <option>100</option>
        </datalist>
        <div class="list">
            <?php
            foreach ($Liste as $val) :
                ?>
                <input type="checkbox" id="idStudent_<?= $val["personne"]["idPersonne"] ?>"
                       onchange="displayCompToEvaluate(<?= $val['personne']['idPersonne'] ?>)">
                <label for="idStudent_<?= $val["personne"]["idPersonne"] ?>" class="list_item_style_2">
                    <div class="flex_row fill space_between">
                        <p><?= $val["personne"]["nom"] ?> <?= $val["personne"]["prenom"] ?><?php if ($val["personne"]["numeroHomnyme"] > 0) {
                                echo $val["personne"]["numeroHomnyme"];
                            } ?></p>
                        <a href="#" onclick="ajaxTableauActiviteDuMoment(<?= $val['personne']['idPersonne'] ?>)"><span
                                    class="close_window"></span></a>
                    </div>
                </label>
                <div id="comp_of_student_<?= $val["personne"]["idPersonne"] ?>" class="list inactive">
                    <?php
                    foreach ($val["competence"] as $comp) :
                        ?>
                        <div class="list_item_style_1 flex_column flex_double_center">
                            <h5><?= $comp["nomCompetence"] ?></h5>
                            <label for="note_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>">Note </label>
                            <input type="range" class="fill_width" min="0" max="100" value="<?= $comp["note"] ?>"
                                   id="note_<?= $val["personne"]["idPersonne"] ?>_<?= $comp["idCompetence"] ?>"
                                   step="10" list="volsettings"
                                   name="note_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>"
                                   oninput='updateSlide(`<?= $val["personne"]["idPersonne"] ?>_<?= $comp["idCompetence"] ?>`)'>


                            <p id="value_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>"
                               class="note"><?= ($comp["note"] != -1) ? ($comp["note"]) : ("-"); ?></p>
                            <input type="checkbox"
                                   name="note_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>"
                                   id="non_note_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>"
                                   onchange="ChangeNonNoter(<?= $val['personne']['idPersonne'] ?>,<?= $comp['idCompetence'] ?>)" <?= ($comp["note"] != -1) ? ("") : ("checked"); ?>>
                            <label for="non_note_<?= $val["personne"]['idPersonne'] ?>_<?= $comp['idCompetence'] ?>"
                                   class="clickable_item_2">non noté</label>

                        </div>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
        <input type="hidden" name="idADM" value="<?= $_SESSION["idActiviteDuMoment"] ?>">
    </form>

    <div id="ActiviteDuMomentAssEleve">
    </div>

<?php include __DIR__ . "/../popups/popChooseEleve.php"; ?>
<?php include __DIR__ . "/../popups/popupCompetencesExistantes.php"; ?>