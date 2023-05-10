<?php
include_once __DIR__."/initEleve.php";

$listeEleve = array();

$isEducateurView = false;
$eleveId = -1;
$current_IME = $Personne['idIMESelected'];
$personne;

if(verify($_POST, "eleveId")) {
    $eleveId = intval($_POST["eleveId"]);
}else{
    $eleveId = intval($Personne['id']);
}
/** @var Database $db */
$eleve = $db->getEleve($eleveId, $current_IME);

if(verify($_POST, "type")) {
    if($_POST["type"] === 'educateurView') {
        $isEducateurView = true;
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include __DIR__."/../include/head.php" ?>
    <title>Accueil</title>
</head>
<body class="scroll_div_element scrollbar_style_1">
<?php include_once __DIR__."/../modules/header.php" ?>
<main class="flex_column flex_double_center center">
    <?php 
        if($isEducateurView) {
            include_once __DIR__."/eleveHeader.php";    
        }
    ?>
    <div id="calendrier" class="flex_column">
        <div id="calendrier_header">
            <div id="choix_type_calender">
                <select id="calendrier_type_selector" name="optionlist" onChange='calendrier_change(this.value, <?= json_encode($selectedDate->format('d-m-Y')); ?>, <?= json_encode($eleveId) ?>);  date_selector_change(<?= json_encode($selectedDate->format('d-m-Y')); ?>, "nomove", <?= json_encode($eleveId) ?>)'>
                    <option>Jour</option>
                    <option>Mois</option>
                    <option>Année</option>
                </select>
            </div>
            <div id="date_selector"></div>
        </div>
        <div id="calendrier_content" class="flex_row flex_wrap"></div> <!-- AJAX DIV -->
    </div>
    <div id="activity_content" class="flex_column flex_double_center flex_wrap"></div> <!-- AJAX DIV -->
    
    <?php
        include_once __DIR__."/popups/popupActiviteInfo.php";
    ?>

</main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/jsEleve/calendrier.js"></script>
    <script>
        date_selector_change(<?= json_encode($today->format('d-m-Y')); ?>, 'nomove', <?= json_encode($eleveId) ?>);
        calendrier_case_clicked("Mois", <?= json_encode($today->format("d-m-Y")) ?>, <?= json_encode($today->format("m")) ?>, <?= json_encode($eleveId) ?>);
    </script>
    <?php include_once __DIR__ . "/../modules/footer.php" ?>