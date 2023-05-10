<?php
$key_word= $_POST["key_word"];
$liste_eleve = $_POST["Listerechercher"];

$liste_eleve = recherche($liste_eleve, $key_word);
foreach($liste_eleve as $eleve) :
    ?>
    <form method="POST" action="/eleve/accueil" class="flex_row flex_double_center eleve_bouton center collection_item_style_1 anim_hover_1">
        <button type="submit" id="EIID_<?= $eleve['id'] ?>" class="center eleve_bouton eleve_bouton_style_1">
            <div id="EIID_<?= $eleve['id'] ?>" class="eleve_list_item">
                <span><?=$eleve['nom']?></span> <span><?=$eleve['prenom']?></span> <span><?= $eleve['numeroHomonyme']!=0?"#".$eleve['numeroHomonyme']:""; ?></span>
            </div>
            <input type="hidden" name="eleveId" value=<?=$eleve['id']?>>
            <input type="hidden" name="type" value="educateurView">
        </button>
    </form>
<?php endforeach; ?>