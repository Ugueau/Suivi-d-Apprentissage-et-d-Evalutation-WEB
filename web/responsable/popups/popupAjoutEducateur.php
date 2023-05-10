<?php
$class_active = 'inactive';
if(isset( $_SESSION['errorManager']['displayLocation'])) {
    if ($_SESSION['errorManager']['displayLocation'] == 'popupAjoutEducateur') {
        if ($_SESSION['errorManager']['code'] != 200) {
            $class_active = 'active';
        }
    }
}

?>

<section id="ajouter_educateur" class="flex_column flex_double_center <?= $class_active ?> popup_init popup_style_1">
    <div class="flex_row popup_title">
        <h3 id="ajout_educateur_title">Création d'une personne</h3>
        <a href="#/" id="quit_popup_competence_existante" onclick="popNoActive('ajouter_educateur')"><span class="close_window"></span></a>
    </div>
    <form method="POST" action="/responsable/traitement/traitementNewEducResp">
        <div class="flex_column flex_double_center popup_content">
            <div id="content" class="flex_row flex_wrap flex_double_center fill_width">
                <div class="flex_column flex_double_center">
                    <?php if($Personne['type'] === 'directeur') : ?>
                        <label>Type: </label>
                        <select name="type" id="type">
                            <option value="">-- Choisissez le type --</option>
                            <option value="responsable">Responsable</option>
                            <option value="educateur">Educateur</option>
                            <option value="directeur">Directeur</option>
                        </select>
                    <?php endif; ?>
                    <label for="nom">Nom: </label>
                    <input id="nom_educateur" type="text" name="nom">
                    <label for="nom">Prenom: </label>
                    <input id="prenom_educateur" type="text" name="prenom">
                    <button type="submit" id="regeneratePassword" class="button_style_2 inactive" onclick="generatePassword();">Réinitialiser le mot de passe</button>
                </div>
                <?php if($Personne['type'] === 'directeur') : ?>
                    <div class="flex_column flex_double_center popup_content">
                        <label for="recherche_competence">Liste des IMEs: </label>
                        <div class="search_zone_style_1">
                            <img src="/img/magnifying-glass.png" alt="loupe" class="loupe">
                            <input type="text" name="recherche_ime" class="searchbar_style_1" id="recherche_ime" onkeyup="updateImeList();)">
                        </div>
                        <div id="recherche_ime_div" class='output list popup_content scrollbar_style_1 scroll_div_element scroll_div_large'></div> <!-- AJAX div -->
                    </div>
                <?php endif ?>

            </div>
            <?php
            if(isset($_SESSION['errorManager']['code'] )) {
                if ($_SESSION['errorManager']['code'] != 200) {
                    echo "<span class='error_message_style_1'>" . $_SESSION['errorManager']['message'] . "</span>";
                    $_SESSION['errorManager']['code'] = 200;
                    $_SESSION['errorManager']['message'] = "";
                }
            }
            ?>
            <input type="hidden" id="input_ime_list" name="IME" value="-1">
            <input type="hidden" id="input_id_to_modify" name="idToModify" value="-1">
            <input type="hidden" id="isModify" name="isModify" value="0">
            <input type="hidden" id="isGeneratePassword" name="isGeneratePassword" value="0">
            <input type="hidden" id="returnPage" name="returnPage" value="<?= $_SERVER['REQUEST_URI'] ?>">
            <button type="submit" id="valider_ajout_educateur" class="button_style_2" onclick="download_the_pdf()">Créer</button>
        </div>
    </form>
</section>