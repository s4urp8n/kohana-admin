<select class="mobile-navigation--secondary">
    <?php
    foreach ($items as $href => $value) {
        ?>
        <option href="<?= $href ?>">
            <?= $value ?>
        </option>
        <?php
    }
    ?>
</select>