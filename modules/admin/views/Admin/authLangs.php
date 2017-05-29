<div class="authLangs">

    <?php
    foreach (Common::getLangs() as $lang) {

        $class = "authLangs-lang";

        if ($lang == Common::getCurrentLang()) {

            Session::instance()
                   ->set('lang', $lang);

            $class = $class . " " . $class . "--active";
        }

        ?>
        <a href="<?= AdminHREF::getFullCurrentHREF(['lang'], ['lang' => $lang]) ?>"
           class="<?= $class ?>">
            <?= $lang ?>
        </a>
        <?php
    }
    ?>
</div>
