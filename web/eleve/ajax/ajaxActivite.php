<?php
include_once __DIR__."/../initEleve.php";

$eleve_id = -1;
$start_date = new DateTime();
$end_date = new DateTime();
$activite_span_text = "Activité(s) effectuée(s)";

if(verify($_POST, "eleve_id")) {
    $eleve_id = $_POST['eleve_id'];
}

if(verify($_POST, "start_date")) {
    $start_date = new DateTime($_POST['start_date']);
}

if(verify($_POST, "end_date")) {
    $end_date = new DateTime($_POST['end_date']);
}

if(verify($_POST, "activite_span_text")) {
    $activite_span_text = $_POST['activite_span_text'];
}

$activites = $db->getActivitesPlayed($eleve_id, $start_date, $end_date);
?>
<div id="activites_effectues" class="flex_column flex_double_center center">
    <span id="activite_effectuees_span"><?php if(count($activites) === 0) echo "Aucune a".substr($activite_span_text, 1, strlen($activite_span_text)); else echo $activite_span_text; ?></span>
</div>
<div id="activite_calendrier" class="flex_row flex_double_center flex_wrap">
<?php
foreach($activites as $activite) :
?>
<div class="activites_effectues_div card_style_1 flex_column flex_double_center center collection_item_style_1 anim_hover_1">
    <a onclick='display_activite_infos(<?= json_encode($activite["idActivite"]) ?>, <?= json_encode($activite["idADM"]) ?>, <?= json_encode($eleve_id) ?>, <?= json_encode($activite["nom"]) ?>, <?= json_encode($activite["description"]) ?>)' class="activites_effectues_boutons flex_column flex_double_center" href="#/">
        <span class="flex_double_center text_center"><?= $activite['nom'] ?></span>
        <span style="font-size:10px">
            <?php
                $date_activite = new DateTime($activite['dateHeure']);
                echo $date_activite->format("d")." ".numberToMonth(intval($date_activite->format("m")))." ".$date_activite->format("Y");
            ?>
        </span>
    </a>
</div>
<?php
endforeach;
?>
</div>