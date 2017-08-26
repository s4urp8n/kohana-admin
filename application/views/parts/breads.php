<?php
if (!empty($breads)) {

    $breads = \Zver\ArrayHelper::load($breads);
    $last = $breads->getLastValueUnset();
    ?>

    <div class="breadcrumbs user-select-none">
        <?php
        foreach ($breads as $href => $name) {
            ?>
            <a href="<?= $href ?>" class="breadcrumbs-item">
                <?= $name ?>
            </a>
            <span class="breadcrumbs-sep">
                /
            </span>
            <?php
        }
        ?>
        <span class="breadcrumbs-current">
            <?= $last ?>
        </span>
        <div class="clearfix"></div>
    </div>
    <?php
}
