<?php
/** @var Database $db */
$listeIME = $db->getIMEs();
if(isset($_POST['search_word']))
    if($_POST['search_word'] != '')
        $listeIME = recherche($listeIME, $_POST['search_word']);
foreach ($listeIME as $IME) :
    ?>
    <div class="clickable_item flex_row flex_double_center clickable_item">
        <input type='checkbox' onchange='setIME(<?= $IME['idIME'] ?>)' id='AE_<?= $IME['idIME'] ?>' name="listIME[]" class='inactive' <?php if(isset($_SESSION)) echo $_SESSION['ime_selected'] == $IME['idIME'] ? "checked" : "" ?>>
        <label class="flex_row flex_double_center flex_wrap" for='AE_<?= $IME['idIME'] ?>'> <span> <?= $IME['nom'] ?> </span> </label>
    </div>
<?php
endforeach;