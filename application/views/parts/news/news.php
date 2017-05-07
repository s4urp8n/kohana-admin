<?php
$request = Request::initial();
/**
 * Request params
 */
$currentPage = $request->query('page');

$module = ORM::factory('MainItem')
             ->where('module', '=', Modules::$MOD_NEWS)
             ->find();

$news = Common::getNews();

?>
<h1><?= $module->get(Common::getCurrentLang() . '_name') ?></h1>

<?php
if (count($news) > 0) {
    echo View::factory('parts/news/news-list', ['news' => $news]);
} else {
    ?>
    <div class="alert alert-info">
        <?= ___('НовостейПокаНет') ?>
    </div>
    <?php
}
?>


