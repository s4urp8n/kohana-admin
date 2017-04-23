<?= View::factory('parts/carousel') ?>

<div class="indexPage">
    <div class="indexPage-left">
        <?= ___('ТекстНаГлавной') ?>
    </div>
    <div class="indexPage-right">

        <h4><?= ___('ПоследниеНовости') ?></h4>
        <?php
        $news = ORM::factory('News')
                   ->where('visible', '=', 1)
                   ->order_by('_datetime', 'desc')
                   ->find_all()
                   ->as_array();

        $news = array_slice($news, 0, 3);
        ?>

        <?= View::factory('parts/news/news-list', ['news' => $news]) ?>

    </div>
</div>

