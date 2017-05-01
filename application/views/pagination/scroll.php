<?php

/** @var \Zver\Pagination $pagination */

$current = $pagination->getCurrentPage();

$prevHref = ($current == 1) ? false : $pagination->getPageUrl($current - 1);
$nextHref = ($current == $pagination->getPagesCount()) ? false : $pagination->getPageUrl($current + 1);

$info = \Zver\StringHelper::getScrollPaginationInfo($pagination->getItemsCount(), $pagination->getItemsPerPage(), $pagination->getOffset());

?>

<div class="pagination-scroll">

    <div class="pagination-scroll-prev">
        <?php
        if ($prevHref !== false) {
            ?>
            <a href="<?= $prevHref ?>" class="pagination-scroll-link">
                &larr;
            </a>
            <?php
        }
        ?>
    </div>

    <div class="pagination-scroll-mid">
        <span class="pagination-scroll-link">
            <?= $info ?>
        </span>
    </div>

    <div class="pagination-scroll-next">
        <?php
        if ($nextHref !== false) {
            ?>
            <a href="<?= $nextHref ?>" class="pagination-scroll-link">
                &rarr;
            </a>
            <?php
        }
        ?>
    </div>

    <div class="clearfix"></div>

</div>