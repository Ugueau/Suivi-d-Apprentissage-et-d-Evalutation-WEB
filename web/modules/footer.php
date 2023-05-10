<footer>
    <div class="flex_row space_around flex_wrap">
        <section class="flex_column flex_double_center">
            <h2>Nos coordonnées</h2>
            <ul class="flex_column flex_double_center">
                <li>
                    <p><?php echo ADDRESS ?></p>
                </li>
                <li>
                    <p><?php echo POSTAL_CODE ?></p>
                <li>
                <li>
                    <p><?php echo CITY ?></p>
                <li>
                <li>
                    <a class='email' href='mailto:".MAIL_ADDRESS."'><?=MAIL_ADDRESS?></a>
                <li>
                <li>
                    <p><?php echo PHONE_NUMBER ?></p>
                </li>
            </ul>
        </section>
        <section class="flex_column flex_double_center">
            <h2>Télécharger l'Appli </h2>
            <ul class="flex_column flex_double_center">
                <li><a href="/APK" class="button_style_3 flex_row">Via l'APK</a></li>
            </ul>
        </section>
        <section class="flex_column flex_double_center">
            <h2>Informations légales</h2>
            <ul class="flex_column flex_double_center">
                <li><a class="button_style_3 flex_row" href="/CGU">Conditions générales d'utilisation</a></li>
                <li><a class="button_style_3 flex_row" href="/PPD">Politique de protection des données</a></li>
            </ul>
        </section>
    </div>

    <div id="copyright" class="fill_width flex_row flex_double_center">
        <p><?php echo COPYRIGHT ?></p>
    </div>
</footer>