<?php
/** @var Database $db */
$liste_educateur = $_SESSION["liste_educateur"];
$liste_educateur_selected = $_SESSION["liste_educateur_selected"];

foreach ($liste_educateur as $educateur) {
    if ($liste_educateur_selected) {
        foreach ($liste_educateur_selected as $educateur_selected) :
            if ($educateur_selected == $educateur["id"]):
                ?>
                <div class=" flex_row space_between list_item_style_2">
                    <label><span><?= $educateur["nom"] ?></span>
                        <span><?= $educateur["prenom"] ?></span> <?php if ($educateur["numeroHomonyme"] != "0") {
                            echo "<span>" . $educateur["numeroHomonyme"] . "</span>";
                        } ?></label>
                    <a href="#/" onclick='remove_liste_educateur(<?= $educateur_selected ?>);
                            $(document).one("ajaxStop", function() {
                            update_educateur();
                            });'><span
                                class="close_window"></span></a>
                </div>
                <input type="hidden" id="custId" name="Educateur[]" value="<?= $educateur['id'] ?>">
            <?php
            endif;
        endforeach;

    }
}