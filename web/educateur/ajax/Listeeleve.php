<?php
/** @var Database $db */
$liste_eleve = $_SESSION["liste_eleve"];
$liste_eleve_selected = $_SESSION["liste_eleve_selected"];

foreach ($liste_eleve as $eleve) {
    if ($liste_eleve_selected) {
        foreach ($liste_eleve_selected as $eleve_selected) :
            if ($eleve_selected == $eleve["id"]):
                ?>

                <div class="flex_row space_between list_item_style_2">
                    <label for="Eleve"> <span><?= $eleve["nom"] ?></span>
                        <span><?= $eleve["prenom"] ?></span> <?php if ($eleve["numeroHomonyme"] != "0") {
                            echo "<span>" . $eleve["numeroHomonyme"] . "</span>";
                        } ?></label>
                    <a href="#/" onclick='remove_liste_eleve(<?= $eleve_selected ?>);
                            $(document).one("ajaxStop", function() {
                                update_Eleve();
                                });'><span
                            class="close_window"></span></a>
                </div>
                <input type="hidden" id="custId" name="Eleve[]" value="<?= $eleve ['id'] ?>">
            <?php
            endif;
        endforeach;
    }
}

