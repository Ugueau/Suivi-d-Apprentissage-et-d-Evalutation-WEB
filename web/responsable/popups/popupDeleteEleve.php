<section id="popupDeleteEleve" class="flex_column flex_double_center inactive popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3>Validation</h3>
        <a href="#" onclick="popNoActive('popupDeleteEleve')"><span class="close_window"></span></a>
    </div>
    <div class="popup_content">
        <p>Êtes-vous sur de vouloir supprimer le compte de cet élève ?</p>
        <div class="flex_row flex_double_center popup_content space_around">
            <form action="/responsable/traitementSuppEleve" method="post">
                <?php
                /** @var Database $db */
                $stm = $db->query("SELECT idIME FROM Responsable where idPersonne = :idPersonne", array('idPersonne' => $_SESSION["personne"]["id"]));
                $idIME = $stm->fetch();
                ?>
                <input type="hidden" name="idEleve" id="idEleve">
                <input type="hidden" name="idIME" id="idIME" value=<?= $idIME->idIME ?>>
                <button class="button_style_2" type="submit"> Oui </button>
                <button class="button_style_2" href="#" onclick="popNoActive('popupDeleteEleve')" type="reset"> Non </button>
            </form>
        </div>
    </div>
</section>

