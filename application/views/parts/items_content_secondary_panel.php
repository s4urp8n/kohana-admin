<select class="mobile-navigation--secondary">

    <option href="<?= Common::getCurrentMainItem()
                            ->getHref() ?>">
        <?= ___('Выберите категорию') ?>
    </option>

    <?php

    foreach ($sec as $s) {
        $class = 'mobile-navigation--secondary-item';

        if ((!empty($current_sec->id) && $current_sec->id == $s->id)) {
            $class = $class . ' ' . $class . "--active";
        }

        ?>
        <option href="<?= $s->getHref() ?>"
                class="<?= $class ?>">
            <?= $s->get(Common::getCurrentLang() . '_name') ?>
        </option>
        <?php
    }
    ?>
</select>

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

