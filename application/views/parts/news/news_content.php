<div class="content-block content-block--with-panel">
    <div class="content-block-panel">
        <?php

        if (!empty($next)) {
            ?>
            <a href="<?= $next->getHREF() ?>" class="content-block-panel-item">
                <p class="nav-helper"><?= ___('Следующая новость') ?> &rarr;</p>
                <?= $next->get(Common::getCurrentLang() . '_caption') ?>
            </a>
            <?php
        }

        if (!empty($previous)) {
            ?>
            <a href="<?= $previous->getHREF() ?>" class="content-block-panel-item">
                <p class="nav-helper">&larr; <?= ___('Предыдущая новость') ?></p>
                <?= $previous->get(Common::getCurrentLang() . '_caption') ?>
            </a>
            <?php
        }

        ?>

    </div>
    <div class="content-block-content">

        <div class="new-content">

            <?php
            $image = $new->getImage();

            if (!empty($image)) {
                ?>
                <img class="new-content-img"
                     src="<?= ImagePreview::getPreview($image, 1000, 400, true, '#ffffff', true) ?>"/>
                <?php
            }
            ?>

            <div class="new-content-caption-block">

                <p class="new-content-date">
                    <?php

                    $date = FieldString::getFullRuDateFromMysqlDate($new->_datetime);

                    $date = FieldString::translateMonth($date);

                    echo $date;

                    ?>
                </p>

                <h1 class="new-content-caption"><?php echo $new->get(Common::getCurrentLang() . '_caption'); ?></h1>

                <div class="clearfix"></div>

            </div>

            <div class="new-content-text">
                <?php
                if (!empty($new->get(Common::getCurrentLang() . '_text'))) {
                    echo $new->get(Common::getCurrentLang() . '_text');
                }
                ?>
            </div>

            <?php
            if (method_exists($new, 'renderGallery')) {
                $new->renderGallery();
            }
            ?>

        </div>

    </div>
    <div class="clearfix"></div>
</div>


