<?php

include_once __DIR__."/../initEleve.php";

$idADM = "";
$eleve_id = "";


if(verify($_POST, 'idADM')) {
    $idADM = $_POST['idADM'];
}

if(verify($_POST, 'idEleve')) {
    $eleve_id = $_POST['idEleve'];
}

/** @var Database $db */
$competenceResultats = $db->getCompetencesAndResultats($eleve_id, $idADM);

if(count($competenceResultats) === 0) :
?>
<div class="competence_resultat_div">
    <span>Aucune compétence notée</span>
</div>
<?php
endif;
foreach($competenceResultats as $element) :
?>
<div class="competence_resultat_div">
    <span><?= $element['nom'] ?></span>
    <span>
        <?php 
            if($element['note'] == "-1") {
                echo "Non noté";
            }else{
                echo "Note: ".$element['note']."/100";
            }
        ?> 
    </span>
</div>
<?php
endforeach;