<?php
if (count($news) > 0) {
    ?>
    <div class="news-list">
        <?php
        foreach ($news as $new) {
            ?>

            <a href="<?= $new->getHREF() ?>" class="news-list-item">


                <?php
                $image = $new->getImage();
                if (empty($image)) {
                    ?>
                    <span class="news-list-item-dummy"></span>
                    <?php
                } else {
                    ?>
                    <img class="news-list-item-image"
                         src="<?= ImagePreview::getPreview($image, 100, 100, true, '#ffffff', true) ?>"/>
                    <?php
                }
                ?>
                <span class="right">

                        <span class="news-list-item-date">
                            <?php

                            $date = FieldString::getFullRuDateFromMysqlDate($new->_datetime);

                            if (Common::getCurrentLang() == 'en') {
                                $date = FieldString::translateMonthToEnglish($date);
                            }

                            echo $date;
                            ?>


                        </span>
                        <span class="news-list-item-caption">
                            <?= $new->get(Common::getCurrentLang() . '_caption') ?>
                        </span>
                        <span class="news-list-item-text">
                            <?= \Zver\StringHelper::load($new->get(Common::getCurrentLang() . '_text'))
                                                  ->removeTags()
                                                  ->getFirstChars(250) . '...' ?>
                        </span>
                    </span>
                <span class="clearfix"></span>
            </a>

            <?php
        }
        ?>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-info">
        <?= ___('НовостейПокаНет') ?>
    </div>
    <?php
}
?>