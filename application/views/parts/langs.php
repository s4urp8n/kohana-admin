<?php

$langs = Common::getLangs();

if (!isset($noreverse)) {
    $langs = array_reverse($langs);
}

foreach ($langs as $lang) {

    $class = "header-langs-lang";

    if ($lang == Common::getCurrentLang()) {
        $class = $class . " " . $class . "--active";
    }

    ?>
    <a href="<?= Common::getChangeLangLink($lang) ?>"
       class="<?= $class ?>">

        <img class="flag" src="/inc/images/<?= $lang ?>-flag.jpg"/>

        <span class="lang">
            <?php
            switch ($lang) {
                case 'ru': {
                    echo "Рус";
                    break;
                }
                case 'en': {
                    echo "Eng";
                    break;
                }
                case 'am': {
                    echo "Հայ";
                    break;
                }
            }

            ?>

        </span>
    </a>
    <?php
}
