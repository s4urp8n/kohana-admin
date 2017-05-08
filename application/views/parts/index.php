<?php

$garden = ORM::factory('MainItem')
             ->where('module', '=', Modules::$MOD_SHOP)
             ->find();

$home = ORM::factory('MainItem')
           ->where('module', '=', Modules::$MOD_ARTICLES)
           ->find();

$gardenSecondaries = [];

$homeSecondaries = [];

?>


<!--<div class="index-choose">-->
<!---->
<!--    <div class="index-choose-part  index-choose-part--right">-->
<!--        <div class="index-choose-links">-->
<!--            --><?php
//            foreach ($gardenSecondaries as $item) {
//                ?>
<!--                <a class="index-choose-links-link" href="--><? //= $item->getHref() ?><!--">-->
<!--                    --><? //= $item->get(Common::getCurrentLang() . '_name') ?>
<!--                </a>-->
<!--                --><?php
//            }
//            ?>
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Натуральная еда-->
<!--            </a>-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Ресторан-->
<!--            </a>-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Оранжерея-->
<!--            </a>-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Натуральная еда-->
<!--            </a>-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Ресторан-->
<!--            </a>-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Оранжерея-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="index-choose-main">-->
<!--            <a href="--><? //= $garden->getHref() ?><!--" class="index-choose-main-link">-->
<!--                --><? //= $garden->get(Common::getCurrentLang() . '_name') ?>
<!--            </a>-->
<!--        </div>-->
<!--        <div class="clearfix"></div>-->
<!--    </div>-->
<!---->
<!--    <div class="index-choose-part index-choose-part--left">-->
<!--        <div class="index-choose-main">-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-main-link">-->
<!--                --><? //= $home->get(Common::getCurrentLang() . '_name') ?>
<!--            </a>-->
<!--        </div>-->
<!--        <div class="index-choose-links">-->
<!--            --><?php
//            foreach ($homeSecondaries as $item) {
//                ?>
<!--                <a class="index-choose-links-link" href="--><? //= $item->getHref() ?><!--">-->
<!--                    --><? //= $item->get(Common::getCurrentLang() . '_name') ?>
<!--                </a>-->
<!--                --><?php
//            }
//            ?>
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Проектирование-->
<!--            </a>-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Строительство-->
<!--            </a>-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Производство-->
<!--            </a>-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Проектирование-->
<!--            </a>-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Строительство-->
<!--            </a>-->
<!--            <a href="--><? //= $home->getHref() ?><!--" class="index-choose-links-link">-->
<!--                Производство-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="clearfix"></div>-->
<!--    </div>-->
<!--    <div class="clearfix"></div>-->
<!---->
<!--</div>-->

<div class="radialContainers">
    <div class="radialContainers-left">
        <div class="radialContainer radialContainer--1">
            <a href="" class="radialContainer-link-main">
                GARDEN
            </a>
            <a href="" class="radialContainer-link radialContainer-link-1">
                Натуральная еда
            </a>
            <a href="" class="radialContainer-link radialContainer-link-2">
                Ресторан
            </a>
            <a href="" class="radialContainer-link radialContainer-link-3">
                Оранжерея
            </a>
        </div>
    </div>

    <div class="radialContainers-right">
        <div class="radialContainer radialContainer--2">
            <a href="" class="radialContainer-link-main">
                HOME
            </a>
            <a href="" class="radialContainer-link radialContainer-link-1">
                Проектирование
            </a>
            <a href="" class="radialContainer-link radialContainer-link-2">
                Строительство
            </a>
            <a href="" class="radialContainer-link radialContainer-link-3">
                Производство
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

