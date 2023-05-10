<?php

    $listCompetences = $db->getCompetences($Personne['idIMESelected']);

    if(isset($_SESSION['listeCompetences'])){
        $listCompetencesExistante = $_SESSION['listeCompetences'];
        
    }else{
        $listCompetences = [];
    }

/*    if($_SESSION['ActiviteData']['refreshData']) {
        $listCompetence = $_SESSION['ActiviteData']['listeCompetence'];
    }*/
    if($listCompetences != [] && $listCompetences != "" && isset($_SESSION['listeCompetences'])) :
        
        foreach($listCompetences as $comp) :
            if(in_array($comp['idCompetence'], $_SESSION['listeCompetences'])) :
?>
<div class='NALCID_<?= $comp["idCompetence"]; ?> flex_row flex_double_center space_between list_item_style_2'>
    <p class='NALCID_<?= $comp["idCompetence"]; ?> '><?= $comp["nom"]; ?> </p>
    <a href='#' onclick='removeCompetenceExistante(<?= $comp["idCompetence"] ?>); updateCompetence()' class='NALCID_<?= $comp["idCompetence"]; ?>'><span class="close_window"></span></a>
    <input type="hidden" id='NALCID_<?= $comp["idCompetence"]; ?> ' name="idCompetences[]" value="<?= $comp["idCompetence"]; ?> ">
</div>
<?php
    endif;
    endforeach;
    endif;
// if($_SESSION['ActiviteData']['refreshData']) {
//     $_SESSION['ActiviteData']['refreshData'] = false;
//     $_SESSION['ActiviteData']['nom'] = "";
//     $_SESSION['ActiviteData']['description'] = "";
//     $_SESSION['ActiviteData']['listeCompetence'] = array();
//     $_SESSION['ActiviteData']['isModifyActity'] = false;
//     $_SESSION['ActiviteData']['idActiviteToModify'] = -1;
// }
?>