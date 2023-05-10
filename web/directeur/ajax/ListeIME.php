<?php
$key_word = $_POST["key_word"];
/** @var Database $db */
$liste_ime = $db->getIMEs();

$liste_ime = recherche($liste_ime, $key_word);

foreach ($liste_ime as $ime) :
    ?>
    <div class="flex_row flex_double_center collection_item_style_1 anim_hover_1">

        <a onclick="popActive('editIME'); init_edit_ime(<?= $ime['idIME'] ?>,'<?= $ime['nom'] ?>','<?= $ime['adresse'] ?>')"
           href="#/" type="submit" id="IMEID_<?= $ime['idIME'] ?>" class="center eleve_bouton eleve_bouton_style_1">
            <div id="IMEID_<?= $ime['idIME'] ?>" class="flex_column flex_double_center">
                <h2><?= $ime['nom'] ?></h2> <span><?php if (!empty(strstr($ime["adresse"], ","))) {
                        ;
                        $address = explode(',', $ime["adresse"]);
                        echo $address[0]."<br>".$address[1];
                    } else {
                        echo $ime["adresse"];
                    } ?></span>
            </div>
            <a href="#/" onclick="popActive('sup'); init_sup_ime(<?= $ime['idIME'] ?>,'<?= $ime['nom'] ?>')"><span
                        class="close_window"></span></a>
        </a>
    </div>
<?php endforeach; ?>

