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

            if (in_array($mainItem->module, [Modules::$MOD_SHOP, Modules::$MOD_ARTICLES])) {

                $image = null;

                /**
                 * Categories
                 */
                $currentCategory = Model_ShopCategories::getCurrentCategoryORM();

                if ($currentCategory === false) {
                    $currentCategory = Model_ArticlesCategories::getCurrentCategoryORM();
                }

                if (!empty($currentCategory) && !empty($currentCategory->image)) {
                    $image = $currentCategory->image;
                }

                /**
                 * subshopcategories
                 */
                if (empty($image)
                    &&
                    !empty($currentCategory)
                    &&
                    $mainItem->module == Modules::$MOD_SHOP
                    &&
                    !empty($currentCategory->id_parent)) {

                    $parent = ORM::factory('ShopCategories', $currentCategory->id_parent);

                    if (!empty($parent->image)) {
                        $image = $parent->image;
                    }

                }

                $request = Request::initial();

                $url = $request->url();

                /**
                 * subarticles
                 */
                if (empty($image) && preg_match('#/article/#i', $url) == 1) {

                    $currentCategory = Model_Articles::getCurrentCategoryORM();

                    if (!empty($currentCategory)) {

                        $parent = ORM::factory('ArticlesCategories', $currentCategory->id_category);

                        if (!empty($parent->image)) {
                            $image = $parent->image;
                        }

                    }

                }
                /**
                 * main item
                 */
                if (empty($image) && !empty($mainItem->image)) {
                    $image = $mainItem->image;
                }

                if (!empty($image)) {
                    ?>

                    <div class="big-breads-caption-svg">
                        <?= $image ?>
                    </div>

                    <?php

                }
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