<?php
$current_main = Common::getCurrentMainItem();
$current_sec = Common::getCurrentSecondaryItem();
$sec = Common::getSecondaryItems($current_main->id, true);
$moduleOptions = Modules::getOptions($item);

if (!empty($moduleOptions['no_content'])) {

    echo Modules::render($item);

} else {

    echo View::factory('parts/breads');

    if ($sec->count() > 0) {
        ?>
        <div class="content-block content-block--with-panel">

            <?= View::factory('parts/items_content_secondary_panel', [
                'sec'         => $sec,
                'current_sec' => $current_sec,
            ]) ?>

            <?= View::factory('parts/items_content_content', ['item' => $item]) ?>

            <div class="clearfix"></div>

        </div>
        <?php
    } else {
        ?>
        <div class="content-block">
            <?= View::factory('parts/items_content_content', ['item' => $item]) ?>
        </div>
        <?php
    }
}

