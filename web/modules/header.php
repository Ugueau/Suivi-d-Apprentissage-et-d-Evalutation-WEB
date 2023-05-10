<header>
    <div class="imageLogo">
        <a href="<?= $_SESSION["nav"]["Accueil"]?>" class="clickable_img">
            <img src="/img/logo3D.png" alt="logo" id="logo">
        </a>
    </div>
    <section class="nav">
        <div>
            <h1><?= getPage($path) ?></h1>
            <div>
                <input type="checkbox" id="profil">
                <label for="profil" onchange="">
                    <span id="profil_label">
                        <img src="/img/iconeProfilBeige.png" alt="iconeProfil" id="profilImg">
                    </span>
                    <span id="nom_IME">
                        <p><?php
                            /** @var ArrayObject $Personne */
                            foreach($Personne["ListeIME"] as $ime){
                            if($ime["id"] == $Personne["idIMESelected"]){
                                echo $ime["nom"];
                            }
                        }
                        ?></p>
                    </span>
                </label>
                <div id="popupProfil">
                    <div class="flex_row flex_double_center space_around">
                        <h2><?= ucfirst($Personne["type"]) ?></h2>
                        <a href="/setting" class="flex_row flex_double_center"><img src="/img/gear_setting.png" alt="paramètre" id="setting_gear"></a>
                    </div>
                    <ul>
                        <li>
                            <p><?= ucfirst($Personne["nom"]) ?> <?= ucfirst($Personne["prenom"]) ?></p>
                        </li>
                        <?php if($Personne["isResponsable"] == 1):
                        ?>
                        <li>
                            <form action='/traitementChangementType' method='post'>
                                <button>Passer en mode <?=$Personne['type']=='educateur'?'Responsable':'Éducateur'?></button>
                            </form>
                        </li>
                        <?php endif;?>
                        <li>
                            <a href="/deconnexion" class="button_style_2">Déconnexion</a>
                        </li>
                    </ul>
                </div>
                <input type="checkbox" id="burger_menu">
                <label for="burger_menu" id="burger_menu_label">
                    <span></span>
                </label>
            </div>
        </div>
        <nav id="nav" class="computerNav">
            <ul>
                <?php
                foreach ($_SESSION["nav"] as $key => $value) :
                ?>
                    <li><a class="menu__item" href="<?= $value ?>"><?= $key ?><span class="next"></span></a></li>
                <?php
                endforeach;
                ?>
            </ul>
        </nav>
    </section>
    <script src="/jsGeneral/header.js"></script>
</header>