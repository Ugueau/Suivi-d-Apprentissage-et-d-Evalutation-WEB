<?php
    include_once __DIR__."/../initEleve.php";
    if(verify($_POST, "idCategorie") && verify($_POST, "eleveId")) :
        $categorieId = $_POST['idCategorie'];
        $eleveId = $_POST['eleveId'];

        /** @var Database $db */
        $competenceList = $db->getCompetencesOfCategorie($categorieId);

    foreach ($competenceList as $competence) :
        $resultats = $db->getResultatsByCompetence($eleveId, $competence['idCompetence']);
        $nbResultats = count($resultats);
        $moyenne = 0;
        if($nbResultats > 0) {
            foreach($resultats as $r) {
                $r['note'] = intval($r['note']);
                if($r['note'] != -1) {
                    $moyenne += $r['note'];
                }else{
                    $nbResultats--;
                }
            }
            $moyenne = (float)($moyenne)/ ($nbResultats == 0 ? 1 : $nbResultats);
        }
    ?>
        <a href="#/" id="eleveCategorieListComp" class="list_item_style_1 flex_row">
            <h4><?= $competence['nom'] ?></h4>
            <p><?= $competence['description'] ?></p>
            <p><?php if($nbResultats === 0) echo 'Non noté'; else echo 'Moyenne: '.$moyenne.'/100'; ?></p>
        </a>
    <?php 
        endforeach;
    endif;
    ?>