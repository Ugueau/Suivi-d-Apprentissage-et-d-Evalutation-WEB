<?php
/** @var Database $db */
$result = $db->getCategories($Personne['idIMESelected']);

if(isset($_POST['data'])) {
    if(json_decode($_POST['data'], true) != "display_all") {
        $result = recherche($result, json_decode($_POST['data'], true));
    }
}


foreach ($result as $value) :
    ?>
    <div class="clickable_item flex_row flex_double_center">
        <input type='checkbox' onchange='<?php if(isset($_SESSION['listeCategories'])) echo in_array($value['idCategorie'], $_SESSION['listeCategories']) ? 'removeCategorieExistante('.$value["idCategorie"].')' : 'addCategorieExistante('.$value["idCategorie"].');'; else echo 'addCategorieExistante('.$value["idCategorie"].');'; ?>' id='CATS_<?= $value['idCategorie'] ?>' class='inactive' <?php if(isset($_SESSION['listeCategories'])) echo in_array($value['idCategorie'], $_SESSION['listeCategories']) ? 'checked' : '' ?>>
        <label class="label_for_input_CATS flex_row flex_double_center flex_wrap" for='CATS_<?= $value['idCategorie'] ?>'> <span> <?= $value['nom'] ?> </span> </label>
    </div>
<?php
endforeach;
?>