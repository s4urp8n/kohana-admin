
<?= View::factory('parts/mobile-breads') ?>

<?= View::factory('parts/mobile-navigation', ['items' => Common::getArticlesMobileNavigation()]) ?>

<div class="content-block content-block--with-panel">

    <div class="content-block-panel">
        <?php

        $categories = ORM::factory('ArticlesCategories')
                         ->where('visible', '=', 1)
                         ->find_all()
                         ->as_array();

        foreach ($categories as $category) {
            ?>

            <a href="<?= $category->getHref() ?>"
               class="content-block-panel-item <?php

               if (Model_ArticlesCategories::getCurrentCategory() == $category->id) {
                   echo " content-block-panel-item--active ";
               }

               ?>">

                <?= $category->get(Common::getCurrentLang() . '_name') ?>

            </a>


            <?php

            $subCategories = ORM::factory('Articles')
                                ->where('visible', '=', 1)
                                ->where('id_category', '=', $category->id)
                                ->find_all()
                                ->as_array();

            foreach ($subCategories as $subCategory) {
                ?>
                <a href="<?= $subCategory->getHref() ?>"
                   class="content-block-panel-item content-block-panel-child  <?php

                   if (Model_ArticlesCategories::getCurrentCategory() == $subCategory->id) {
                       echo " content-block-panel-item--active ";
                   }

                   ?>">

                    <?= $subCategory->get(Common::getCurrentLang() . '_name') ?>

                </a>
                <?php
            }

        }
        ?>

    </div>

    <div class="content-block-content">


        <?php
        $currentCategory = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

        $currentCategory = Model_ShopCategories::getList()
                                               ->find($currentCategory);

        if ($currentCategory === false) {

            echo ___('HomeИнтроТекст');

        } else {

            echo ORM::factory('ArticlesCategories', Model_ArticlesCategories::getCurrentCategory())
                    ->get(Common::getCurrentLang() . '_description');

        }

        ?>

    </div>

    <div class="clearfix"></div>

</div>