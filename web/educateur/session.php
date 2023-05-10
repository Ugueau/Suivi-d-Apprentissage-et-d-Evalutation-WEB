<?php
$_SESSION["liste_eleve_selected"]=array();
/** @var Database $db */
/** @var ArrayObject $path_array */
$_SESSION["liste_eleve"] = $db->rechercherPersonne($Personne["idIMESelected"], 'eleve');
$_SESSION["idActiviteDuMoment"]=$path_array[count($path_array)-1];
?>

<html lang="fr">

<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <title>Accueil Éducateur</title>
</head>

<body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php" ?>
    <main>
        <div id="tableauAjax" class="fill flex_column flex_double_center">

        </div>
    </main>
    <?php include_once __DIR__ . "/../modules/footer.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/jsEducateur/activiteDuMoment.js"></script>
    <script src="/jsEducateur/popUp.js"></script>
    <script src="/jsEducateur/nouvelle_activite.js"></script>
    <script src="/jsEducateur/rechercheElevePop.js"></script>

    <script>
        ajaxTableauActiviteDuMoment();
    </script>
</body>


</html>