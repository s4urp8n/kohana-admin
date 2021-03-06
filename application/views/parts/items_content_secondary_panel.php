<?php
$mobile = [
    Common::getCurrentMainItem()
          ->getHref() => Common::getCurrentMainItem()
                               ->get(Common::getCurrentLang() . '_name'),
];

foreach ($sec as $s) {
    $mobile[$s->getHref()] = Common::getMobileTab() . $s->get(Common::getCurrentLang() . '_name');
}

echo View::factory('parts/mobile-navigation', ['items' => $mobile]);

?>

<div class="content-block-panel">
    <?php

    foreach ($sec as $s) {
        $class = 'content-block-panel-item';

        if ((!empty($current_sec->id) && $current_sec->id == $s->id)) {
            $class = $class . ' ' . $class . "--active";
        }

        ?>
        <a href="<?= $s->getHref() ?>"
           class="<?= $class ?>">
            <?= $s->get(Common::getCurrentLang() . '_name') ?>
        </a>
        <?php
    }
    ?>
</div>

