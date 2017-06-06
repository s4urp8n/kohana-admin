<div class="content-block-panel">
    <?php

    $categories = Model_ShopCategories::getList(true)
                                      ->getItems();

    foreach ($categories as $category) {

        $orm = ORM::factory('ShopCategories', $category->getId());

        ?>

        <a href="<?= $orm->getHref() ?>"
           class="content-block-panel-item <?php

           if (Model_ShopCategories::getCurrentCategory() == $category->getId()) {
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

                   if (Model_ShopCategories::getCurrentCategory() == $child->getId()) {
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
