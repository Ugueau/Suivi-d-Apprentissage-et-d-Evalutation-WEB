<?php

$fisrtCo = false;
if (isset($_SESSION['First']) and $_SESSION['First'] == true) {
    $fisrtCo = true;
    $_SESSION['First'] = false;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once __DIR__ ."/include/head.php" ?>
    <title>Suivi d'Apprentissage et d'Évaluation</title>
</head>

<body>
    <main id="page_connection" class="flex_column flex_double_center">
        <section id="connexion" class="flex_column flex_double_center block_style_1 space_between">
            <h2>Connexion</h2>
            <form class="flex_column flex_double_center form_style_1" method="post" name="un">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" autofocus>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password">

                <p class="error_message_style_1"><?php echo getError(); ?></p>
                <button type="submit" class="button_style_2">Se Connecter</button>
            </form>
            <div class="flex_column flex_double_center">
                <button onclick="bouttonFirstConnexion()" class="button_style_3">Première connexion ?</button>
            </div>
        </section>

        <section id="FirstConnexion" class="flex_column flex_double_center block_style_1 space_between">
            <h2>Première Connexion</h2>
            <form class='flex_column flex_double_center form_style_1' method="post" name="deux">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom">
                <label for="Prenom">Prénom :</label>
                <input type="text" name="Prenom" id="Prenom">
                <input type="hidden" name="FistCo" value="true">

                <label for="code">Code :</label>
                <input type="password" name="code" id="code">

                <p class="error_message_style_1"><?php echo getError(); ?></p>

                <button type="submit" class="button_style_2">Envoyer</button>
            </form>
            <div>
                <button onclick="bouttonConnexion()" class="button_style_3">Déjà inscrit ? - Se connecter</button>
            </div>
        </section>
        <script src="/jsGeneral/index.js"></script>
        <script>
            var fisrtCo = '<?= $fisrtCo ?>';
            if (fisrtCo) {
                bouttonFirstConnexion();
            } else {
                bouttonConnexion();
            }
        </script>
    </main>
    <?php include __DIR__ . '/modules/footer.php' ?>
</body>
</html>

<?php
if (!isset($_SESSION["id"])) {
    $_SESSION = array();
    session_destroy();
}

?>