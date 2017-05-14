<div class="content-block-content">

    <?php
    if ($item->show_caption == 1) {
        ?>
        <h1><?= \Zver\StringHelper::load($item->get(Common::getCurrentLang() . '_name'))
                                  ->toLowerCase()
                                  ->toUpperCaseFirst() ?></h1>
        <?php
    }
    ?>

    <?php
    if (!\Zver\StringHelper::load($item->get(Common::getCurrentLang() . '_content'))
                           ->removeTags()
                           ->isEmpty()
    ) {
        ?>
        <div>
            <?= $item->get(Common::getCurrentLang() . '_content') ?>
        </div>


        <?php
        if (method_exists($item, 'renderGallery')) {
            $item->renderGallery();
        }
        ?>

        <?php
    }
    ?>

    <?php
    $modulesOutput = Modules::render($item);
    if (!\Zver\StringHelper::load($modulesOutput)
                           ->removeTags()
                           ->isEmpty()
    ) {
        ?>
        <div>
            <?= $modulesOutput ?>
        </div>
        <?php
    }
    ?>

</div>
