<?php
include_once __DIR__."/../initEleve.php";

$action_type = "";
$calendrier_type = "Jour";
$date = $selectedDate;
$eleve_id = -1;

if(verify($_POST, "date")) {
    $date = new DateTime($_POST['date']);
    $date->setTimezone(new DateTimeZone("Europe/Paris"));
}

if(verify($_POST, "calendrier_type")) {
    $calendrier_type = $_POST['calendrier_type'];
}

if(verify($_POST, "eleve_id")) {
    $eleve_id = $_POST['eleve_id'];
}


?>

<div id="date_selector_div" class="flex_row flex_double_center space_between">
    <a href="#/" onclick='date_selector_change(<?=json_encode($date->format("d-m-Y")); ?>, "back", <?= json_encode($eleve_id) ?>);' style="<?php if(intval($date->format("Y")) < 2022) echo "display: none;"?>"><</a>
    <div id="date_span_div" class="flex_column flex_double_center">
        <span id="date_span">
            <?php
            if($calendrier_type == "Jour"){
                echo numberToMonth($date->format("m"))." ". $date->format("Y");
            }else if($calendrier_type == "Mois") {
                echo $date->format("Y");
            }else if($calendrier_type == "Année") {
                echo $date->format("Y")." - ".strval(intval($date->format("Y")) + 35);
            }
            ?>
        </span>
    </div>
    <a href="#/" onclick='date_selector_change(<?=json_encode($date->format("d-m-Y")); ?>, "forward", <?= json_encode($eleve_id) ?>)' style="<?php if($date >= $today) echo "display: none;"?>">></a>
</div>