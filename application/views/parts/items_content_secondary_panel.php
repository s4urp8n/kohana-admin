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
