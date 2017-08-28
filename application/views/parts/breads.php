<?php

$breads = [
    '/' => AdminHREF::getHost(),
];

$mainItem = Common::getCurrentMainItem();
$secondaryItem = Common::getCurrentSecondaryItem();
$additional = Common::getCurrentSpecialItem();

if (!empty($mainItem)) {
    $breads[$mainItem->getHref()] = $mainItem->get(Common::getCurrentLang() . '_name');
}

if (!empty($secondaryItem)) {
    $breads[$secondaryItem->getHref()] = $secondaryItem->get(Common::getCurrentLang() . '_name');
}

switch ($mainItem->module) {
    case Modules::$MOD_SHOP: {

        $list = Model_ShopCategories::getList();
        $request = Request::initial();
        $url = $request->url();
        $current = false;

        if ($additional) {
            $current = $list->find($additional->id);
        } elseif ($request->query('category')) {
            $current = $list->find($request->query('category'));
        }

        if ($current) {

            $parents = $current->getRecursiveDataProperty('id');

            foreach ($parents as $parent) {

                $parent = ORM::factory('ShopCategories', $parent);

                $breads[$parent->getHref()] = $parent->get(Common::getCurrentLang() . '_name');
            }
        }

        if (preg_match('#/good/#i', $url) == 1) {

            $good = ORM::factory('Goods', $request->param('id'));

            $breads[$good->getHref()] = $good->get('title_' . Common::getCurrentLang());
        }

        break;
    }
    case Modules::$MOD_NEWS: {

        $id = Request::initial()
                     ->param('id');

        $newOrm = ORM::factory('News', $id);

        if (!empty($newOrm->id)) {
            $breads[$newOrm->getHref()] = $newOrm->get(Common::getCurrentLang() . '_caption');
        }

        break;
    }
    case Modules::$MOD_ARTICLES: {
        if (!empty($additional)) {

            if (get_class($additional) == Model_ArticlesCategories::class) {
                $breads[$additional->getHref()] = $additional->get(Common::getCurrentLang() . '_name');
            } else {

                $categoryOrm = ORM::factory('ArticlesCategories', $additional->id_category);

                $breads[$categoryOrm->getHref()] = $categoryOrm->get(Common::getCurrentLang() . '_name');
                $breads[$additional->getHref()] = $additional->get(Common::getCurrentLang() . '_name');
            }

        }
        break;
    }
}

if (!empty($breads)) {

    $breads = \Zver\ArrayHelper::load($breads);
    $last = $breads->getLastValueUnset();
    ?>

    <div class="breadcrumbs user-select-none">
        <?php
        foreach ($breads as $href => $name) {
            ?>
            <a href="<?= $href ?>" class="breadcrumbs-item">
                <?= $name ?>
            </a>
            <span class="breadcrumbs-sep">
                /
            </span>
            <?php
        }
        ?>
        <span class="breadcrumbs-current">
            <?= $last ?>
        </span>
        <div class="clearfix"></div>
    </div>
    <?php
}
