<?php

$mobile = isset($mobile);

$mainItems = Common::getMainItemsTransliterated(empty($activeId) ? null : $activeId);

if (!empty($mainItems)) {
    ?>
    <div class="header-navigation user-select-none">
        <?php
        foreach ($mainItems as $main_item) {

            $stringItem = \Zver\StringHelper::load($main_item[Common::getCurrentLang() . '_name']);
            $ormItem = ORM::factory('MainItem', $main_item['id']);

            if ($ormItem) {

                if (in_array($ormItem->module, [
                    Modules::$MOD_ARTICLES,
                    Modules::$MOD_SHOP,
                ])) {

                    if ($ormItem->module == Modules::$MOD_ARTICLES) {

                        $class = "navigation-item";

                        if ($main_item['active']) {
                            $class = $class . ' ' . $class . '--active';
                        }
                        ?>

                        <a href="<?= $main_item['href'] ?>"
                           class="<?= $class ?> home-item"
                        >
                            <?= $stringItem->getClone()
                                           ->toUpperCaseFirst()
                                           ->get() ?>
                        </a>
                        <?php

                        if ($mobile) {

                            $categories = ORM::factory('ArticlesCategories')
                                             ->where('visible', '=', 1)
                                             ->find_all()
                                             ->as_array();

                            foreach ($categories as $category) {

                                ?>

                                <a href="<?= $category->getHref() ?>"
                                   class="navigation-item navigation-item--sub <?php

                                   if (Model_ArticlesCategories::getCurrentCategory() == $category->id) {
                                       echo " navigation-item--active ";
                                   }

                                   ?>">
                                    <?= $category->get(Common::getCurrentLang() . '_name') ?>
                                </a>


                                <?php
                            }

                        }

                    } else {
                        $class = "navigation-item";

                        if ($main_item['active']) {
                            $class = $class . ' ' . $class . '--active';
                        }
                        ?>

                        <a href="<?= $main_item['href'] ?>"
                           class="<?= $class ?> garden-item"
                        >
                            <?= $stringItem->getClone()
                                           ->toUpperCaseFirst()
                                           ->get() ?>
                        </a>

                        <?php

                        $categories = Model_ShopCategories::getList(true)
                                                          ->getItems();

                        if ($mobile) {

                            foreach ($categories as $category) {
                                $orm = ORM::factory('ShopCategories', $category->getId());
                                ?>

                                <a href="<?= $orm->getHref() ?>"
                                   class="navigation-item navigation-item--sub <?php

                                   if (Model_ShopCategories::getCurrentCategory() == $category->getId()) {
                                       echo " navigation-item--active ";
                                   }

                                   ?>">
                                    <?= $category->getDataProperty(Common::getCurrentLang() . '_name') ?>
                                </a>


                                <?php
                            }
                        }
                    }

                } else {

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
        }
        ?>

        <div class="clearfix"></div>
    </div>
    <?php
}
?>