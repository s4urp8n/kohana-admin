<?php

$garden = ORM::factory('MainItem')
             ->where('module', '=', Modules::$MOD_SHOP)
             ->find();

$home = ORM::factory('MainItem')
           ->where('module', '=', Modules::$MOD_ARTICLES)
           ->find();

$gardenSecondaries =
    \Zver\ArrayHelper::load(Model_ShopCategories::getList()
                                                ->getItems())
                     ->slice(0, 3)
                     ->get();

$gardenSecondaries = array_map(function ($value) {
    return ORM::factory('ShopCategories', $value->getId());
}, $gardenSecondaries);

$homeSecondaries = ORM::factory('ArticlesCategories')
                      ->where('visible', '=', 1)
                      ->limit(3)
                      ->order_by(Common::getCurrentLang() . '_name')
                      ->find_all()
                      ->as_array();

?>

<div class="radialContainers">

    <div class="radialContainers-logo animated fadeInDown">
        <img src="/inc/images/lusin_group_green.svg"/>
        <div class="slogan"><?= ___('ПриветствиеНаГлавнойСтраницеТекст') ?></div>
    </div>

    <div class="radialContainers-left animated fadeInLeft">
        <div class="radialContainer radialContainer--1">
            <a href="<?= $garden->getHref() ?>" class="radialContainer-link-main">
                <?= \Zver\StringHelper::load($garden->get(Common::getCurrentLang() . '_name'))
                                      ->toUpperCaseFirst()
                                      ->get() ?>
            </a>

            <?php
            $index = 0;
            foreach ($gardenSecondaries as $item) {
                $index++;
                ?>
                <a href="<?= $item->getHref() ?>"
                   class="radialContainer-link radialContainer-link-<?= $index ?>">
                    <?= $item->get(Common::getCurrentLang() . '_name') ?>
                </a>
                <?php
            }
            ?>

        </div>
    </div>

    <div class="radialContainers-right animated fadeInRight">
        <div class="radialContainer radialContainer--2">
            <a href="<?= $home->getHref() ?>" class="radialContainer-link-main">
                <?= \Zver\StringHelper::load($home->get(Common::getCurrentLang() . '_name'))
                                      ->toUpperCaseFirst()
                                      ->get() ?>
            </a>

            <?php
            $index = 0;
            foreach ($homeSecondaries as $item) {
                $index++;
                ?>
                <a href="<?= $item->getHref() ?>"
                   class="radialContainer-link radialContainer-link-<?= $index ?>">
                    <?= $item->get(Common::getCurrentLang() . '_name') ?>
                </a>
                <?php
            }
            ?>

        </div>
    </div>
    <div class="clearfix"></div>

    <?=View::factory('parts/social')?>

</div>

