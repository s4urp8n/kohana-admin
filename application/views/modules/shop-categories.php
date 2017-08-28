<div class="content-block-panel">
    <?php

    $request = Request::initial();

    $categories = Model_ShopCategories::getList(true)
                                      ->getItems();

    $active = [];
    $activeCategory = Model_ShopCategories::getCurrentCategory();

    if (!empty($activeCategory)) {
        $active[] = $activeCategory;
    }

    if (!empty($request->query('category'))) {
        $active[] = $request->query('category');
    }

    foreach ($categories as $category) {

        $orm = ORM::factory('ShopCategories', $category->getId());

        ?>

        <a href="<?= $orm->getHref() ?>"
           class="content-block-panel-item <?php

           if (in_array($category->getId(), $active)) {
               echo " content-block-panel-item--active ";
           }

           ?>">
            <?= $category->getDataProperty(Common::getCurrentLang() . '_name') ?>
        </a>


        <?php
        if ($category->haveChildren()) {
            foreach ($category->getChildren() as $child) {
                $ormChild = ORM::factory('ShopCategories', $child->getId());
                ?>
                <a href="<?= $ormChild->getHref() ?>"
                   class="content-block-panel-item content-block-panel-child <?php

                   if (in_array($ormChild->id, $active)) {
                       echo " content-block-panel-child--active ";
                   }

                   ?>">
                    <?= $child->getDataProperty(Common::getCurrentLang() . '_name') ?>
                </a>
                <?php
            }
        }
        ?>

        <?php
    }
    ?>

</div>
