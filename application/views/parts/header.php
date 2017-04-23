<?php
$mainItems = Common::getMainItemsTransliterated(empty($activeId) ? null : $activeId);
?>


<div class="header">

    <a class="header-logo" href="/<?= Common::getCurrentLang() ?>">
        <div class="header-logo-logo">
            <?= getFileContent('inc/images/logo.svg') ?>
        </div>
        <div class="header-logo-slogan">
            <div class="header-logo-slogan-name">
                <?= ___('НазваниеФирмыЛого') ?>
            </div>
            <div class="header-logo-slogan-slogan">
                <?= ___('СлоганФирмы') ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </a>

    <div class="header-langs">
        <?php
        foreach (Common::getLangs() as $lang) {

            $class = "header-langs-lang";

            if ($lang == Common::getCurrentLang()) {
                $class = $class . " " . $class . "--active";
            }

            ?>
            <a href="<?= Common::getChangeLangLink($lang) ?>"
               class="<?= $class ?>">
                <?= $lang == 'ru' ? "Рус" : "Eng" ?>
            </a>
            <?php
        }
        ?>
        <div class="clearfix"></div>
    </div>


    <div class="header-contacts">

        <a class="header-contacts-address"
           target="_blank"
           href="https://yandex.ru/maps/35/krasnodar/?text=<?= urlencode(___('КонтактныйАдрес')) ?>">
            <?= ___('КонтактныйАдрес') ?>
        </a>

        <a class="header-contacts-phone"
           target="_blank"
           href="tel:<?= \Zver\StringHelper::load(Settings::get('contact_phone'))
                                           ->remove("\s")
                                           ->remove("\(")
                                           ->remove("-")
                                           ->remove("\)")
                                           ->get() ?>">
            <?= Settings::get('contact_phone') ?>
        </a>


        <a class="header-contacts-email"
           target="_blank"
           href="mailto:<?= Settings::get('contact_email') ?>">
            <?= Settings::get('contact_email') ?>
        </a>

    </div>

    <div class="clearfix"></div>
</div>

<?php
if (!empty($mainItems)) {
    ?>
    <div class="navigation">
        <div class="navigation-inner">
            <?php
            foreach ($mainItems as $main_item) {

                $class = "navigation-inner-item";

                if ($main_item['active']) {
                    $class = $class . ' ' . $class . '--active';
                }
                ?>
                <a href="<?= $main_item['href'] ?>"
                   class="<?= $class ?>">
                    <?= $main_item[Common::getCurrentLang() . '_name'] ?>
                </a>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}
?>

