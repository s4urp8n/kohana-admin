<?php
$currentColor = Common::getCurrentColor();

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
    $caption = "Home";
    if ($homeLink) {
        $href = $homeLink->getHref();
    }
} elseif ($currentColor == Common::COLOR_YELLOW) {
    $logo = getFileContent('inc/images/lusin_garden.svg');
    $caption = "Garden";
    if ($gardenLink) {
        $href = $gardenLink->getHref();
    }
}

$currentMainItem = Common::getCurrentMainItem()
                         ->get(Common::getCurrentLang() . '_name');

if (!\Zver\StringHelper::load($currentMainItem)
                       ->trimSpaces()
                       ->isEqualsIgnoreCase($caption)
) {
    $caption .= ' / ' . $currentMainItem;
}

?>

<div class="big-breads">
    <div class="big-breads-inner">
        <a class="big-breads-logo" href="<?= $href ?>">
            <?= $logo ?>
        </a>
        <div class="big-breads-caption">
            <span class="big-breads-caption-text">
            <?= $caption ?>
            </span>
        </div>

        <div class="clearfix"></div>

    </div>
</div>