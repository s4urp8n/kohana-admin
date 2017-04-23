<?php
$module = ORM::factory('MainItem')
             ->where('module', '=', Modules::$MOD_NEWS)
             ->find();

$year = \Zver\StringHelper::load($new->_datetime)
                          ->getParts(0, '-');

$month = \Zver\StringHelper::load($new->_datetime)
                           ->getParts(1, '-');

$prev = null;
$next = null;

$news = ORM::factory('News')
           ->where('visible', '=', 1)
           ->order_by('_datetime', 'desc')
           ->find_all()
           ->as_array();

foreach ($news as $key => $value) {
    if ($value->id == $new->id) {
        if (!empty($news[$key - 1])) {
            $prev = $news[$key - 1];
        }
        if (!empty($news[$key + 1])) {
            $next = $news[$key + 1];
        }
    }
}

?>

<?php
$translatedMonth = FieldString::translateMonthRuFromNumber($month);

if (Common::getCurrentLang() == 'en') {
    $translatedMonth=FieldString::translateMonthToEnglish($translatedMonth);
}

?>

<?= View::factory('parts/breads', [
    'breads' => [
        $module->getHref()                                         => $module->get(Common::getCurrentLang() . '_name'),
        $module->getHref() . '?year=' . $year                      => $year,
        $module->getHref() . "?year=" . $year . "&month=" . $month => $translatedMonth,
        $new->get(Common::getCurrentLang() . '_caption'),
    ],
]) ?>

<div class="new-content">

    <div class="new-content-caption-block">

        <p class="new-content-date">

            <?php
            $date = FieldString::getFullRuDateFromMysqlDate($new->_datetime);

            if (Common::getCurrentLang() == 'en') {
                $date = FieldString::translateMonthToEnglish($date);
            }

            echo $date;
            ?>
        </p>

        <h1 class="new-content-caption"><?php echo $new->get(Common::getCurrentLang() . '_caption'); ?></h1>

        <div class="clearfix"></div>
    </div>

    <div class="new-content-text">
        <?php
        if (!empty($new->get(Common::getCurrentLang() . '_text'))) {
            echo $new->get(Common::getCurrentLang() . '_text');
        }
        ?>
    </div>

    <?php
    if (method_exists($new, 'renderGallery')) {
        $new->renderGallery();
    }
    ?>
</div>

<?php
if (!empty($next) || !empty($prev)) {
    ?>
    <div class="news-navigation">
        <?php
        if (!empty($prev)) {
            ?>
            <a href="<?= $prev->getHREF() ?>" class="news-navigation-prev">
                <span class="news-navigation-prev-image">
                    <?= getFileContent('inc/images/arrow-left.svg') ?>
                </span>
                <span class="news-navigation-prev-text">
                    <span class="news-navigation-prev-text-date">
                        <?php
                        $prevDate = FieldString::getFullRuDateFromMysqlDate($prev->_datetime);

                        if (Common::getCurrentLang() == 'en') {
                            $prevDate = FieldString::translateMonthToEnglish($prevDate);
                        }

                        echo $prevDate;

                        ?>
                    </span>
                    <span class="news-navigation-prev-text-caption">
                        <?= $prev->get(Common::getCurrentLang() . '_caption') ?>
                    </span>
                </span>
                <span class="clearfix"></span>
            </a>
            <?php
        }
        ?>
        <?php
        if (!empty($next)) {
            ?>
            <a href="<?= $next->getHREF() ?>" class="news-navigation-next">
                <span class="news-navigation-next-image">
                    <?= getFileContent('inc/images/arrow-right.svg') ?>
                </span>
                <span class="news-navigation-next-text">
                    <span class="news-navigation-next-text-date">
                        <?php
                        $nextDate = FieldString::getFullRuDateFromMysqlDate($next->_datetime);

                        if (Common::getCurrentLang() == 'en') {
                            $nextDate = FieldString::translateMonthToEnglish($nextDate);
                        }

                        echo $nextDate;
                        ?>
                    </span>
                    <span class="news-navigation-next-text-caption">
                        <?= $next->get(Common::getCurrentLang() . '_caption') ?>
                    </span>
                </span>
                <span class="clearfix"></span>
            </a>
            <?php
        }
        ?>
        <div class="clearfix"></div>
    </div>
    <?php
}
?>

