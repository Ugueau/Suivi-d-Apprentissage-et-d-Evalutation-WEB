<?php
include_once __DIR__."/../initEleve.php";

$nb_iteration = 1;
$start_iteration = 1;
$calendrier_type = "Jour";
$format_type = "d";
$selectedDate = "";
$eleve_id = -1;
$activite_played = "";

if(verify($_POST, 'eleve_id')) {
    $eleve_id = $_POST['eleve_id'];
}


if(verify($_POST, 'calendrier_type')) {
    $calendrier_type = $_POST['calendrier_type'];
}

if(verify($_POST, 'date')) {
    $selectedDate = new Datetime($_POST['date']);
    $selectedDate->setTimezone(new DateTimeZone("Europe/Paris"));
}

if(strcmp(strval($calendrier_type), "Année") == 0) {
    $format_type = "Y";
    $nb_iteration = 36;
    $start_iteration = intval($selectedDate->format("Y"));
    $activite_played = $db->getActivitesPlayed($eleve_id, new DateTime("01-01-".strval($start_iteration)), new DateTime("31-12-".strval($start_iteration+$nb_iteration)));
}else if($calendrier_type == "Mois") {
    $format_type = "m";
    $nb_iteration = 12;
    $start_iteration = 1;
    $activite_played = $db->getActivitesPlayed($eleve_id, new DateTime("01-01-".$selectedDate->format("Y")), new DateTime("31-12-".$selectedDate->format("Y")));
}else if($calendrier_type == "Jour") {
    $nb_iteration = getDayNumber($selectedDate->format('m'), $selectedDate->format('Y'));
    $format_type = "d";
    $start_iteration = 1;
    $activite_played = $db->getActivitesPlayed($eleve_id, new DateTime("01-".$selectedDate->format("m-Y")), new DateTime("31-".$selectedDate->format("m-Y")));
}

for($i = $start_iteration; $i < $start_iteration + $nb_iteration; $i++) :
?>

<a href="#/" onclick='calendrier_case_clicked(<?= json_encode($calendrier_type) ?>, <?= json_encode($selectedDate->format("d-m-Y")) ?>, <?= json_encode($i) ?>, <?= json_encode($eleve_id) ?>)' style="<?php if(!displayCase($calendrier_type, $selectedDate, $today, $i)) echo "pointer-events:none"; else ""; ?>">
    <div class="flex_column calendrier_case <?php  if(isEquals($today, $selectedDate, "d-m-Y") && $selectedDate->format($format_type) == $i) echo "today_case"; if(!displayCase($calendrier_type, $selectedDate, $today, $i)) echo "disabled_case"; ?>">
        <span>
            <?php
                if($calendrier_type == "Mois") {
                    echo numberToMonth($i);
                } else if($calendrier_type == "Jour") {
                    $tempDate = new DateTime($i."-".$selectedDate->format("m")."-".$selectedDate->format("Y"));
                    echo getStringDay($tempDate->format("N"))." ".$i;
                } else {
                    echo $i;
                }
            ?>
         </span>
         <span class="nombre_activite_jouees">
            <?php
                $compteur = 0;
                $value = $i;
                if($value < 10) {
                    $value = "0".strval($i);
                }
                $value = strval($value);
                foreach($activite_played as $activite) {
                    $activite_date = new DateTime($activite['dateHeure']);
                    if($calendrier_type == "Jour") {
                        if($activite_date->format("d-m-Y") == $value."-".$selectedDate->format("m-Y")) {
                            $compteur ++;
                        }
                    }else if($calendrier_type == "Mois") {
                        if($activite_date->format("m-Y") == $value."-".$selectedDate->format("Y")) {
                            $compteur ++;
                        }
                    }else if($calendrier_type == "Année") {
                        if($activite_date->format("Y") == $value) {
                            $compteur ++;
                        }
                    }
                }
                if($compteur > 0) {
                    echo strval($compteur)." activité(s) jouée(s)";
                }
            ?>
         </span>
    </div>
</a>

<?php 
endfor; 

?>