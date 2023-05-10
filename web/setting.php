<!doctype html>
<html lang="fr">
<head>
    <?php
    require_once __DIR__."/include/head.php"
    ?>
    <title>Setting</title>
</head>
<body class="scroll_div_element scrollbar_style_1">
<?php include_once __DIR__ . "/modules/header.php" ?>
<main>
    <ul class="list block_style_1" id="setting">
        <li><h2>Profil</h2></li>
        <li class="list_item_style_1 flex_row flex_double_center"><p><b>Prenom :</b> <?= /** @var ArrayObject $Personne */
                $Personne["prenom"]?></p></li>
        <li class="list_item_style_1 flex_row flex_double_center"><p><b>Nom : </b><?=$Personne["nom"]?></p></li>
        <?php if($Personne["numeroHomonyme"]!=0) :
        ?>
            <li class="list_item_style_1 flex_row flex_double_center"><p><b>Numéro homonyme : </b><?=$Personne["numeroHomonyme"]?></p></li>
            <?php
        endif;
        ?>
        <li class="list_item_style_1 flex_row flex_double_center">
            <?php if(empty($Personne["ListeIME"])):?>
            <p><b>Liste IME :</b></p>
            <select onChange="" name="comboIME">
                <?php
                foreach ($Personne["ListeIME"] as $value) :
                    ?>
                    <option <?= ($Personne["idIMESelected"] == $value["id"]) ? ("selected") : ("") ?> value="<?= $value["id"] ?>"><?= $value["nom"] ?></option>
                <?php
                endforeach;
                ?>

            </select>
            <?php endif;?>
        </li>
        <li class="list_item_style_1 flex_row flex_double_center"><p><b>Rôle : </b><?=ucfirst($Personne["type"])?></p></li>
        <li class="list_item_style_1 flex_row flex_double_center"><a class="button_style_2" href="/newMdp">Changer le mot de passe</a></li>
        <li class="list_item_style_1 flex_row flex_double_center"><a class="button_style_2" href="#" onclick="confirmRemove()">Supprimer votre compte</a></li>
    </ul>
</main>
<?php include_once __DIR__ . "/modules/footer.php" ?>
<script src="/jsGeneral/setting.js"></script>
</body>
</html>