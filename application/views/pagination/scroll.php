<?php
$prevHref = HTML::chars($page->url($previous_page));
$nextHref = HTML::chars($page->url($next_page));
$info = \Str\Str::getScrollPaginationInfo($total_items, $items_per_page, $offset, ', ', '-', ' из ');
?>

<div class="pagination-scroll">

    <div class="pagination-scroll-prev">
        <?php
        if ($previous_page !== false) {
            ?>
            <a href="<?= $prevHref ?>" class="pagination-scroll-link">
                <svg version="1.1"
                     class="pagination-scroll-link-img"
                     xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px"
                     y="0px"
                     viewBox="0 0 25 50"
                     style="enable-background:new 0 0 25 50;"
                     xml:space="preserve">
                    <polyline points="25.3,-0.6 3,22.2 25.3,50.3 "/>
                </svg>
                <span class="pagination-scroll-link-text">
                    Назад
                </span>
            </a>
            <?php
        }
        ?>
    </div>

    <div class="pagination-scroll-mid">
        <span class="pagination-scroll-mid-text">
            <?= $info ?>
        </span>
    </div>

    <div class="pagination-scroll-next">
        <?php
        if ($next_page !== false) {
            ?>
            <a href="<?= $nextHref ?>" class="pagination-scroll-link">
                <span class="pagination-scroll-link-text">
                    Вперед
                </span>
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     class="pagination-scroll-link-img"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px"
                     y="0px"
                     viewBox="0 0 25 50"
                     style="enable-background:new 0 0 25 50;"
                     xml:space="preserve">
                    <polyline points="0,-0.6 22.3,22.2 0,50.3 "/>
                </svg>
            </a>
            <?php
        }
        ?>
    </div>

</div>