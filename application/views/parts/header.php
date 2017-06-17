<?php
$mainItems = Common::getMainItemsTransliterated(empty($activeId) ? null : $activeId);
?>


<div class="header">
    <div class="page-container">

        <div class="header-row">

            <?php
            if (!empty($mainItems)) {
                ?>
                <div class="header-navigation">
                    <?php
                    foreach ($mainItems as $main_item) {

                        $stringItem = \Zver\StringHelper::load($main_item[Common::getCurrentLang() . '_name']);
                        $ormItem = ORM::factory('MainItem', $main_item['id']);

                        if ($ormItem) {

                            if (!in_array($ormItem->module, [
                                Modules::$MOD_INDEX,
                                Modules::$MOD_CABINET,
                                Modules::$MOD_CART,
                            ])
                            ) {

                                $class = "navigation-item";

                                if ($main_item['active']) {
                                    $class = $class . ' ' . $class . '--active';
                                }

                                if ($stringItem->getClone()
                                               ->toLowerCase()
                                               ->trimSpaces()
                                               ->isEquals(Common::GARDEN)
                                ) {

                                    $class = $class . ' garden-item';

                                } elseif ($stringItem->getClone()
                                                     ->toLowerCase()
                                                     ->trimSpaces()
                                                     ->isEquals(Common::HOME)
                                ) {
                                    $class = $class . ' home-item';
                                }

                                ?>
                                <a href="<?= $main_item['href'] ?>"
                                   class="<?= $class ?>">
                                    <?= $stringItem->getClone()
                                                   ->toUpperCaseFirst()
                                                   ->get() ?>
                                </a>
                                <?php
                            } elseif ($ormItem->module == Modules::$MOD_CART) {

                                $class = "navigation-item";

                                if ($main_item['active']) {
                                    $class = $class . ' ' . $class . '--active';
                                }
                                ?>

                                <a href="<?= $main_item['href'] ?>"
                                   class="<?= $class ?> cart"
                                >

                                    <i class="fa fa-shopping-cart"></i>

                                    <?= Cart::getCount() ?>

                                </a>
                                <?php

                            } elseif ($ormItem->module == Modules::$MOD_CABINET) {

                                $class = "navigation-item";

                                if ($main_item['active']) {
                                    $class = $class . ' ' . $class . '--active';
                                }

                                $href = "/admin/auth?lang=" . Common::getCurrentLang();
                                $title = ___('Вход/Регистрация');

                                if (Auth::instance()
                                        ->logged_in('admin')
                                ) {
                                    $title = ___('Администрирование');
                                } elseif (Auth::instance()
                                              ->logged_in()
                                ) {
                                    $title = ___('Личный кабинет');
                                }
                                ?>

                                <a href="<?= $href ?>" class="<?= $class ?>">
                                    <?= $title ?>
                                </a>

                                <?php
                            }
                        }
                    }
                    ?>

                    <div class="clearfix"></div>
                </div>
                <?php
            }
            ?>


            <div class="header-langs">

                <div class="header-langs-inner">


                    <?php
                    foreach (array_reverse(Common::getLangs()) as $lang) {

                        $class = "header-langs-lang";

                        if ($lang == Common::getCurrentLang()) {
                            $class = $class . " " . $class . "--active";
                        }

                        ?>
                        <a href="<?= Common::getChangeLangLink($lang) ?>"
                           class="<?= $class ?>">
                            <?= $lang ?>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="clearfix"></div>

                </div>
                <div class="clearfix"></div>
            </div>

        </div>

    </div>

</div>

