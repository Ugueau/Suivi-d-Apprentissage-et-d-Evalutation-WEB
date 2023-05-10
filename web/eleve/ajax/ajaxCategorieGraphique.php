<?php
include_once __DIR__."/../initEleve.php";

if(verify($_POST, "idCategorie") && verify($_POST, "eleveId")) :
    $categorieId = $_POST['idCategorie'];
    $eleveId = $_POST['eleveId'];
?>

<div>
<div class="flex_row" style="justify-content: space-between">
    <div id="categorie_graphique_linear_<?= $categorieId ?>"></div> <!-- AJAX DIV -->
    <div id="categorie_graphique_histogram_<?= $categorieId ?>"></div> <!-- AJAX DIV --> 
</div>
</div>

<?php
endif;