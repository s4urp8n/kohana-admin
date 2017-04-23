<?php
$request = Request::initial();
/**
 * Request params
 */
$currentYear = $request->query('year');
$currentMonth = $request->query('month');
$module = ORM::factory('MainItem')
             ->where('module', '=', Modules::$MOD_NEWS)
             ->find();
/**
 * Available years
 */
$years = \Zver\FileCache::retrieve(
    'newsYears', function () {
    return array_values(
        DB::select([DB::expr('YEAR(_datetime)'), 'year'])
          ->from('news')
          ->distinct(true)
          ->where('visible', '=', 1)
          ->order_by(DB::expr('YEAR(_datetime)'), 'desc')
          ->execute()
          ->as_array('year', 'year')
    );
}
);

if (!empty($years)) {

    /**
     * By default get last year
     */
    if (empty($currentYear) || !in_array($currentYear, $years) || !is_numeric($currentYear)) {
        $currentYear = $years[0];
    }

    /**
     * Available months in defined year
     */
    $months = \Zver\FileCache::retrieve(
        'newsMonths' . $currentYear, function () use ($currentYear) {
        return array_values(
            DB::select([DB::expr('MONTH(_datetime)'), 'month'])
              ->from('news')
              ->distinct(true)
              ->where('visible', '=', 1)
              ->where(DB::expr('YEAR(_datetime)'), '=', $currentYear)
              ->order_by(DB::expr('MONTH(_datetime)'), 'desc')
              ->execute()
              ->as_array('month', 'month')
        );
    }
    );

    /**
     * Last month by default
     */
    if (empty($currentMonth) || !in_array($currentMonth, $months) || !is_numeric($currentMonth)) {
        $currentMonth = $months[0];
    }
    ?>

    <form class="newsForm" action="" method="get">

        <div class="left">
            <h1>
                <?= $module->get(Common::getCurrentLang() . '_name') ?>
            </h1>
        </div>

        <div class="right">

            <?php
            if (count($years) > 1) {
                echo Form::select('year', array_combine($years, $years), $currentYear);
            }
            ?>

            <?php
            if (count($months) > 1) {

                $months = array_combine($months, $months);

                $months = array_map(function ($value) {
                    $result = \Zver\StringHelper::load(FieldString::translateMonthRuFromNumber($value));

                    if (Common::getCurrentLang() !== 'ru') {
                        $result->set(FieldString::translateMonthToEnglish($result->get()));
                    }

                    return $result->toUpperCaseFirst()
                                  ->get();

                }, $months);

                echo Form::select('month', $months, $currentMonth);
            }
            ?>

        </div>
        <div class="clearfix"></div>

    </form>

    <script>
        $(document).ready(function () {
            $('.newsForm select').on('change', function () {
                $('.newsForm').submit();
            });
        });
    </script>

    <?php
    $news = ORM::factory('News')
               ->where('visible', '=', 1)
               ->where(DB::expr('YEAR(_datetime)'), '=', $currentYear)
               ->where(DB::expr('MONTH(_datetime)'), '=', $currentMonth)
               ->order_by('_datetime', 'desc')
               ->find_all()
               ->as_array();
    ?>

    <?= View::factory('parts/news/news-list', ['news' => $news]) ?>

    <?php
} else {
    ?>
    <div class="alert alert-info">
        <?= ___('НовостейПокаНет') ?>
    </div>
    <?php
}
?>