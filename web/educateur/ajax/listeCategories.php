<?php
if (isset($_SESSION['listeCategories'])) {
    $listCategories = $_SESSION['listeCategories'];
    $AllCategories = $db->getCategories($Personne['idIMESelected']);

    foreach ($AllCategories as $cat) :
        if(in_array($cat['idCategorie'], $listCategories)) :
?>
        <div class='NALCATID_<?= $cat['idCategorie'] ?> flex_row space_between list_item_style_2'>
            <p class='NALCATID_<?= $cat['idCategorie'] ?>'><?= $cat['nom'] ?></p>
            <a href='#' onclick='removeCategorieExistante(<?= $cat['idCategorie'] ?>); updateCategorie();' class='NALCATID_<?= $cat['idCategorie'] ?>'><span class="close_window"></span></a>
            <input type="hidden" id='NCAT_<?= $cat['idCategorie'] ?>' name="idCategories[]" value="<?= $cat['idCategorie'] ?>">
        </div>
<?php
    endif;
    endforeach;
}
?>