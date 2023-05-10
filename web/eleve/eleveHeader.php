<div id="educateurViewHeader">
    <div class="flex_column flex_double_center center">
    <span>Vous êtes sur l'espace de <?= $eleve["nom"] ?> <?=$eleve["prenom"]?> </span>
        <div id="educateurViewNav" class="flex_row">
            <form method="POST" action="/eleve/accueil">
                <input type="hidden" name="eleveId" value=<?=$eleveId?>>
                <input type="hidden" name="type" value="educateurView">
                <button type="submit" class="button_style_2">Accueil</button>
            </form>
            <form method="POST" action="/eleve/categories">
                <input type="hidden" name="eleveId" value=<?=$eleveId?>>
                <input type="hidden" name="type" value="educateurView">
                <button type="submit" class="button_style_2">Catégories</button>
            </form>
        </div>
    </div>
</div>