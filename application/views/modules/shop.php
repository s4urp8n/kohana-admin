<div class="content-block content-block--with-panel">

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

    <div class="content-block-content">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias inventore laboriosam molestias necessitatibus,
        perspiciatis quia quisquam velit? Blanditiis consectetur corporis cupiditate debitis illo itaque, labore
        mollitia nemo optio provident, suscipit.
    </div>

    <div class="clearfix"></div>

</div>