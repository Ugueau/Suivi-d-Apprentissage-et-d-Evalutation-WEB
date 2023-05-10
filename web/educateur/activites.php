<?php
$ime = $Personne["idIMESelected"]; //faire la detection de l'ime grace à une drop box
/** @var Database $db */
$statement = $db->query("select idActivite,  nom, description, idIME from Activite where idIME = :idIME_;", array("idIME_" => $ime));
$listActivite = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <title>Activités</title>
</head>

<body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php"; ?>
    <main id="page_educateur_activites">
        <script src="/jsEducateur/popUp.js"></script>
        <div id="addActivity">
            <a href="nouvelle_activite" class="button_style_2">Créer une Activité</a>
        </div>
        <div class="collection">
            <?php
            foreach ($listActivite as $activite) :
            ?>
                <form method="POST" action="nouvelle_activite" class="collection_item_style_1 anim_hover_1">
                    <input type="hidden" id="idActivite" name="idActivite" value="<?= $activite->idActivite ?>">
                    <input type="hidden" id="isModifyActivity" name="isModifyActivity" value="true">
                    <button type="submit" class="fill button_style_3">
                        <h2><?= $activite->nom ?></h2>
                        <p class="text_ellipsis"><?= $activite->description ?></p>
                    </button>
                </form>
            <?php endforeach ?>
        </div>
        <div id="ajax_activite_div"></div>
    </main>
    <script src="/jsEducateur/nouvelle_activite.js"></script>
    <?php
    include_once __DIR__ . "/../modules/footer.php";
    ?>