<?php
$_SESSION["liste_eleve_selected"] = array();
$_SESSION["liste_educateur_selected"] = array();
$_SESSION["activite_selected"] = array();

$limit=0;
if(isset($_SERVER["HTTP_REFERER"])){
    if ($path_array[count($path_array) - 1] === "more" &&$path_array[count($path_array) - 2] === "accueil" && $path_array[count($path_array) - 3] === "educateur") {
        $limit = $_SESSION["historique"]["limite"] + 10;
        $_SESSION["historique"]["limite"] = $limit;
    } else {
        $limit = 10;
        $_SESSION["historique"]["limite"] = $limit;
    }
}else{
    $limit=10;
    $_SESSION["historique"]["limite"]=$limit;
}


/** @var Database $db */
$histo = $db->query("select am.idActiviteDuMoment id, a.nom nom , am.dateHeure date ,group_concat(p.nom,' ',p.prenom) eleves 
from ActiviteDuMoment am 
join Activite a on am.idActivite=a.idActivite 
join gere g on g.idActiviteDuMoment=am.idActiviteDuMoment
left join joue j on j.idActiviteDuMoment=am.idActiviteDuMoment 
left join Personne p on p.idPersonne=j.idPersonne
where g.idPersonne=:id
and a.idIME=:idIME
group by 1
order by 3 desc", array(
    'id' => $Personne["id"],
    "idIME" => $Personne["idIMESelected"]
));
/** @var Database $db */
$_SESSION["liste_eleve"] = $db->rechercherPersonne($Personne["idIMESelected"], 'eleve');
$_SESSION["liste_educateur"] = $db->rechercherPersonne($Personne["idIMESelected"], 'educateur');
$_SESSION["liste_activite"] = $db->rechercherArticle($Personne["idIMESelected"]);


?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <?php include __DIR__ . "/../include/head.php" ?>
        <title>Accueil Éducateur</title>
    </head>

    <body class="scroll_div_element scrollbar_style_1">
    <?php include_once __DIR__ . "/../modules/header.php" ?>
    <main class="flex_column flex_double_center">
        <a href="#historique_anchor" class="button_style_2 margin_bottom"> <h2>Historique</h2></a>
        <section class="flex_column flex_double_center block_style_2">

            <form class="form_style_1 flex_column flex_double_center space_between" method="post"
                  id="creation_activite">
                <input type="hidden" name="insertNewActiviteMoment" value="true">

                <h2>Création d'une Session</h2>

                <p class="error_message_style_1"><?php echo getError(); ?></p>
                <a href="#" class="button_style_2" onclick="popActive('popActivite')"><span id="activite">Choix d'une Activité</span></a>
                <div class="flex_row space_between flex_wrap " id="creation_button_block">
                    <div class="list_creation flex_column border padding borderRadius">
                        <a href="#" class="button_style_2" onclick="popActive('listeEducateur')">Ajout d'un
                            Éducateur</a>
                        <section class="flex_column">
                            <h4> Liste des enseignants : </h4>
                            <div id="educateur">

                            </div>
                        </section>
                    </div>

                    <div class="list_creation flex_column border padding borderRadius">
                        <a href="#" class="button_style_2" onclick="popActive('listeEleve')">Ajout d'un Élève</a>
                        <section class="flex_column">
                            <h4> Liste des participants : </h4>
                            <div id="eleve">

                            </div>
                        </section>
                    </div>
                </div>
                <button type="submit" class="button_style_0">DÉBUT</button>
            </form>
        </section>

        <div class="flex_column flex_double_center historique">

            <div class="list border borderRadius padding_top padding_bottom" id="historique_anchor">
                <h2>Historique</h2>
                <?php
                $nbrElements = $histo->rowCount();
                if($limit<=$nbrElements){
                    $nbrAncre=$limit-10;
                }else{
                    $nbrAncre = floor($nbrElements/10)*10;
                }

                $count = 0;
                foreach ($histo as $value) :
                    ?>
                    <div id="<?= ($count == $nbrAncre) ? "historique_add" : "" ?>" class="list_item_style_1 flex_row flex_double_center space_between anim_hover_1">
                        <a href='/educateur/session/<?= $value->id ?>' class="fill">
                            <div class="flex_column">
                                <span><b><?= $value->nom ?></b></span><span><?php $formated_date = date_parse($value->date);
                                    if ($formated_date["day"] < 10) {
                                        echo "0";
                                    };
                                    echo $formated_date["day"] . "/";
                                    if ($formated_date["month"] < 10) {
                                        echo "0";
                                    };;
                                    echo $formated_date["month"] . "/" . $formated_date["year"] . "  ";
                                    if ($formated_date["hour"] < 10) {
                                        echo "0";
                                    };
                                    echo $formated_date["hour"] . ":";
                                    if ($formated_date["minute"] < 10) {
                                        echo "0";
                                    };
                                    echo $formated_date["minute"]; ?></span><span><?= $value->eleves ?><?php echo " "; ?></span>
                            </div>
                        </a>

                        <a href='/educateur/rejouer/<?= $value->id ?>' class="button_style_2">rejouer</a>
                    </div>
                <?php
                    $count++;
                    if ($count == $limit) {
                        // Sortir de la boucle
                        break;
                    }
                endforeach;
                ?>
                <a href="/educateur/accueil/more#historique_add" class="button_style_2" onclick="window.location.reload()">Voir plus</a>
            </div>
        </div>
        <?php include __DIR__ . "/popups/popChooseEleve.php"; ?>

        <?php include __DIR__ . "/popups/popChooseEducateur.php"; ?>

        <?php include __DIR__ . "/popups/popChooseActivite.php"; ?>
    </main>
    <?php include_once __DIR__ . "/../modules/footer.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/jsEducateur/popUp.js"></script>
    <script src="/jsEducateur/rechercheElevePop.js"></script>
    <script src="/jsEducateur/rechercheEducateurPop.js"></script>
    <script src="/jsEducateur/rechercheActivitePop.js"></script>
    <script src="/jsEducateur/accueil.js"></script>
    <script>
        rechercher_eleve('');
        rechercher_educateur('');
        rechercher_activite('');
        $(document).one('ajaxStop', function () {
            add_liste_educateur(<?= $Personne["id"] ?>);
            $(document).one('ajaxStop', function () {
                update_educateur();
            });
        });


    </script>

    </body>

    </html>

<?php
$_SESSION["error"] = null;