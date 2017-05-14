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
        }
        ?>

    </div>

    <div class="content-block-content">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias inventore laboriosam molestias necessitatibus,
        perspiciatis quia quisquam velit? Blanditiis consectetur corporis cupiditate debitis illo itaque, labore
        mollitia nemo optio provident, suscipit.

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquam cumque delectus distinctio dolor eaque eius
        eos error exercitationem harum incidunt iure magnam maiores nam placeat quam, repellat repellendus tempora!
    </div>

    <div class="clearfix"></div>

</div>