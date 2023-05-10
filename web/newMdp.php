<?php
$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

// Vérification des champs requis
    if (empty($newPassword)) {
        $errors[] = "Le champ du nouveau mot de passe est requis";
    }

    if (empty($confirmPassword)) {
        $errors[] = "Le champ de confirmation du mot de passe est requis";
    }

// Vérification de la correspondance des mots de passe
    if ($newPassword !== $confirmPassword) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

// Vérification des critères de validation pour le mot de passe
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $newPassword)) {
        $errors[] ="Le mot de passe doit contenir au moins 8 caractères";
        $errors[] ="une lettre majuscule";
        $errors[] ="une lettre minuscule";
        $errors[] ="un chiffre";
        $errors[] ="un caractère spécial (parmi @$!%*?&)";
    }

// Si le formulaire est valide, traiter le nouveau mot de passe
    if (empty($errors)) {
        /** @var Database $db */
        $db->ModifyPassWord($Personne["id"], $newPassword);

        $isResp = $db->query("select isResponsable(:id) iR",array('id' => $Personne["id"]));
        $isResp = $isResp->fetch();

        $getPersonne = $db->query("call getPersonne(:id,@nom,@prenom,@numeroH,@type,@idIME,@nomIME); select @nom nom ,@prenom prenom ,@numeroH numeroHomonyme,@type type,@idIME idIME,@nomIME nomIME", array('id' => $Personne["id"]));
        $getPersonne->nextRowset();
        $out = $getPersonne->fetch();
        $idIME=explode(',', $out->idIME);
        $nomIME=explode(',', $out->nomIME);

        //$Personne = new Personne($Personne->id, $out->nom, $out->prenom, $out->numeroH, $out->type, $out->idIME);
        $_SESSION['personne'] = array(
            "id" => $Personne["id"],
            "nom" => $out->nom,
            "prenom" => $out->prenom,
            "numeroHomonyme" => $out->numeroHomonyme,
            "type" => $out->type,
            "idIMESelected" => $out->idIME[0],
            "isResponsable" => $isResp->iR
        );
        $cpt = 0;
        foreach ($idIME as $val) {
            $_SESSION['personne']["ListeIME"][$val] = array(
                "id" => $val,
                "nom" => $nomIME[$cpt]
            );
            $cpt++;
        }
        $_SESSION['error'] = 0;
        $type = $out->type;
        require_once __DIR__."/initNav.php";

        //echo $Personne["id"]." ".$out->nom." ".$out->prenom." ".$out->numeroHomonyme." ".$out->type." ";
        header("Location: " . $out->type . "/accueil");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include __DIR__ . "/include/head.php"
    ?>
    <title>Suivi d'Apprentissage et d'Évaluation</title>
</head>

<body class="scrollbar_style_1">
    <main>
        <section id="newMDP" class="flex_column flex_double_center block_style_1 space_between inactive">
            <h2>Nouveau Mot de passe</h2>
            <form class='flex_column flex_double_center form_style_1' method="post" name="nPSW">
                <label for="newPassword">Nouveau mot de passe :</label>
                <input type="password" name="newPassword" id="newPassword" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" class="invalid" autofocus >
                <ul class="invalid ulNewMDP" id="caracteristiqueNewMdp">
                    <li>Le mot de passe doit contenir au moins 8 caractères</li>
                    <li>une lettre majuscule</li>
                    <li>une lettre minuscule</li>
                    <li>un chiffre</li>
                    <li>un caractère spécial (parmi @$!%*?&)</li>
                </ul>
                <label for="confirmPassword">Confirmation du mot de passe</label>
                <input type="password" name="confirmPassword" id="confirmPassword" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" class="invalid">
                <!--<ul class="invalid ulNewMDP" id="caracteristiqueConfMdp">
                    <li>Les mots de passe ne correspondent pas</li>
                </ul>-->
                <span class="invalid ulNewMDP" id="caracteristiqueConfMdp">Les mots de passe ne correspondent pas</span>
                <ul>
                    <?php
                    foreach ($errors as $error):
                    ?>
                        <li><?=$error?></li>
                    <?php
                    endforeach;
                    ?>

                </ul>

                <button type="submit" class="button_style_2">Envoyer</button>
            </form>
        </section>
        <section id="manual" class="flex_column flex_double_center block_style_1 space_around active fill_width">
            <h2>Manuel d'Explication</h2>
            <div action="#" class="flex_column flex_double_center form_style_1">
                <p class="list_item_style_1">Une fois votre mot de passe changé, il faudra vous connecter via les champs "nom d'utilisateur" et "mot de passe".
                    <br></br>Votre nom d'utilisateur sera :
                </p>
                <p class="block_style_3">
                    <?= $Personne["nom"]?>.<?= $Personne["prenom"]?>
                    <?= ( $_SESSION["personne"]["numeroHomonyme"] != 0)? $Personne["numeroHomonyme"]:""?>
                </p>
                <h2>Conditions générales d'utilisation</h2>
                <p class="witheback border borderRadius CGU"><?=CONDITION_UTILIDATION  ?></p>
                <div class="flex_row flex_double_center list_item_style_1">
                    <input type="checkbox" name="agreeTerms" id="agreeTerms" onchange="manual();" class="inactive">
                    <label for="agreeTerms" class="button_style_2">J'accepte</label>
                </div>
            </div>
        </section>
        <script src="/jsGeneral/index.js"></script>
        <script src="/jsGeneral/newMdp.js"></script>
        <script >
            var erreur = '<?= !empty($errors) ?>';
            if (erreur) {
                manual();
            }
        </script>
    </main>
    <?php
    require_once __DIR__."/modules/footer.php"
    ?>
</body>

</html>