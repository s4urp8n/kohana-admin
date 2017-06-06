<div class="content-block content-block--with-panel">

    <?= View::factory('modules/shop-categories') ?>

    <div class="content-block-content">

        <?php
        $currentCategory = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

        $currentCategory = Model_ShopCategories::getList()
                                               ->find($currentCategory);

        if ($currentCategory === false) {

            echo ___('GardenИнтроТекст');

        } else {

            $productCategories = array_merge($currentCategory->getRecursiveChildrenIds(), [$currentCategory->getId()]);

            $products = ORM::factory('Goods')
                           ->join('goods_categories')
                           ->on('goods_categories.id_good', '=', 'goods.id')
                           ->where('goods_categories.id_category', 'in', $productCategories)
                           ->find_all();

            if ($products->count() > 0) {

                ?>

                <div class="products">
                    <?php

                    foreach ($products as $product) {

                        echo View::factory('modules/shop-item')
                                 ->set('product', $product);

                    }
                    ?>
                </div>
                <?php

            } else {
                ?>

                <div class="alert">
                    <?= ___('ВДаннойКатегорииПокаНетТоваров') ?>
                </div>

                <?php

            }

        }

        ?>

    </div>

    <div class="clearfix"></div>

</div>