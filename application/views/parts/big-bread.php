<?php
$currentColor = Common::getCurrentColor();

$mainItem = Common::getCurrentMainItem();
$secondaryItem = Common::getCurrentSecondaryItem();

$logo = getFileContent('inc/images/lusin_group_green.svg');
$caption = 'Group';
$href = '/' . Common::getCurrentLang() . '/';

$gardenLink = ORM::factory('MainItem')
                 ->where('module', '=', Modules::$MOD_SHOP)
                 ->find();

$homeLink = ORM::factory('MainItem')
               ->where('module', '=', Modules::$MOD_ARTICLES)
               ->find();

if ($currentColor == Common::COLOR_BLUE) {
    $logo = getFileContent('inc/images/lusin_home.svg');
    $caption = Common::HOME;
    if ($homeLink) {
        $href = $homeLink->getHref();
    }
} elseif ($currentColor == Common::COLOR_YELLOW) {
    $logo = getFileContent('inc/images/lusin_garden.svg');
    $caption = Common::GARDEN;
    if ($gardenLink) {
        $href = $gardenLink->getHref();
    }
}

$additional = Common::getCurrentSpecialItem();

if ($additional) {
    $caption .= ' / ' . $additional->get(Common::getCurrentLang() . '_name');
} else {

    if ($secondaryItem) {
        $caption .= ' / ' . $secondaryItem->get(Common::getCurrentLang() . '_name');
    } elseif ($mainItem) {

        $newCaption = \Zver\StringHelper::load($mainItem->get(Common::getCurrentLang() . '_name'))
                                        ->trimSpaces()
                                        ->get();

        if (!\Zver\StringHelper::load($caption)
                               ->trimSpaces()
                               ->isEqualsIgnoreCase($newCaption)) {
            $caption .= ' / ' . $newCaption;
        }

    }

}

?>

<div class="big-breads user-select-none">
    <div class="big-breads-inner">
        <a class="big-breads-logo" href="<?= $href ?>">
            <?= $logo ?>
        </a>
        <div class="big-breads-caption">

            <?php

            $image = Common::getCurrentItemImage();

            if (!empty($image)) {
                ?>

                <div class="big-breads-caption-svg">
                    <?= $image ?>
                </div>

                <?php

            }
            ?>

            <div class="big-breads-caption-text">
                <?= \Zver\StringHelper::load($caption)
                                      ->toTitleCase()
                                      ->get() ?>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>
</div>