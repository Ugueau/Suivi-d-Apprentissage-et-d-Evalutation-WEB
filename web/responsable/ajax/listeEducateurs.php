<?php
/** @var ArrayObject $Personne */
/** @var Database $db */
$defaultImeId = -1;
if($Personne['type'] == 'directeur') {
    $listeEducateurs = $db->getPersonnels();

}else{
    $listeEducateurs = $db->rechercherPersonne($Personne['idIMESelected'], 'educateur');
}
if (isset($_POST['search_word']))
    if ($_POST['search_word'] != '')
        $listeEducateurs = recherche($listeEducateurs, $_POST['search_word']);
foreach ($listeEducateurs as $educateur) :
    ?>
    <div class="list_item_style_1 flex_row space_between">
        <div class="flex_row flex_wrap fill_width flex_double_center">
            <span class="text_center"><?= $educateur['nom'] . " " . $educateur['prenom'] ?></span>
        </div>


        <div class="flex_row flex_wrap flex_double_center">
            <a href="#/" class='button_style_3' onclick='popActive("ajouter_educateur"); fill_fields(true, "<?= $educateur['id'] ?>", "<?= $educateur['nom'] ?>", "<?= $educateur['prenom'] ?>", "<?= $educateur['idIME'] ?>");'>Modifier</a>
            <a href="#/" class="button_style_3" onclick='setIdEducateur(<?= $educateur['id'] ?>); popActive("popupDeleteEducateur")'>Supprimer</a>
        </div>
    </div>
<?php
endforeach;
