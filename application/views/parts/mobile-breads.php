<?php
$mainItem = Common::getCurrentMainItem();
$secondaryItem = Common::getCurrentSecondaryItem();
$caption = Common::getCurrentMobileBreadCaption();
?>

<div class="mobile-breads user-select-none">
    <div class="mobile-breads-caption">

        <?php

        $image = Common::getCurrentItemImage();

        if (!empty($image)) {
            ?>

            <div class="mobile-breads-caption-svg">
                <?= $image ?>
            </div>

            <?php
        }
        ?>

        <div class="mobile-breads-caption-text">
            <?= \Zver\StringHelper::load($caption)
                                  ->toTitleCase()
                                  ->get() ?>
        </div>
    </div>

    <div class="clearfix"></div>
</div>