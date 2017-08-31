<?= View::factory('parts/breads') ?>

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
               class="content-block-panel-item">

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

                   if ($article->id == $subCategory->id) {
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
        <?= $article->get(Common::getCurrentLang() . '_description') ?>
    </div>

    <div class="clearfix"></div>

</div>