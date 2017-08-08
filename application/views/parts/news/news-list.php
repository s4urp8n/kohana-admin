<div class="news-list">
    <?php

    $request = Request::initial();

    $pagination = \Zver\Pagination::create();

    $pagination->setItems($news);
    $pagination->setItemsPerPage(5);

    $pagination->setPageUrlCallback(function ($number) {

        $item = ORM::factory('MainItem')
                   ->where('module', '=', Modules::$MOD_NEWS)
                   ->find();

        return $item->getHref() . '?page=' . $number;
    });

    $pagination->setCurrentPageCallback(function () use ($request, $pagination) {

        $page = $request->query('page');

        if (empty($page)) {
            $page = 1;
        }

        $pagesCount = $pagination->getPagesCount();

        if ($page > $pagesCount) {
            $page = $pagesCount;
        }

        return $page;
    });

    $pagination->showItems(function ($news, \Zver\Pagination $pagination) {
        foreach ($news as $new) {
            ?>

            <a href="<?= $new->getHREF() ?>" class="news-list-item">


                <?php
                $image = $new->getImage();
                if (empty($image)) {
                    ?>
                    <span class="news-list-item-dummy"></span>
                    <?php
                } else {
                    ?>
                    <img class="news-list-item-image"
                         src="<?= ImagePreview::getPreview($image, 100, 100, true, '#ffffff', true) ?>"/>
                    <?php
                }
                ?>
                <span class="right">

                        <span class="news-list-item-date">
                            <?php

                            $date = FieldString::getFullRuDateFromMysqlDate($new->_datetime);

                            if (Common::getCurrentLang() == 'en') {
                                $date = FieldString::translateMonthToEnglish($date);
                            }

                            if (Common::getCurrentLang() == 'am') {
                                $date = FieldString::translateMonthToArmenian($date);
                            }

                            echo $date;
                            ?>


                        </span>
                        <span class="news-list-item-caption">
                            <?= $new->get(Common::getCurrentLang() . '_caption') ?>
                        </span>
                        <span class="news-list-item-text">
                            <?= \Zver\StringHelper::load($new->get(Common::getCurrentLang() . '_text'))
                                                  ->removeTags()
                                                  ->getFirstChars(200) . '...' ?>
                        </span>
                    </span>
                <span class="clearfix"></span>
            </a>

            <?php
        }
    });

    $pagination->showPages(function ($pages, \Zver\Pagination $pagination) {

        echo View::factory('pagination/scroll', [
            'pagination' => $pagination,
        ]);

    });

    ?>
</div>
