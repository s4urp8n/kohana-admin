<div class="footer">
    <div class="footer-texts">
        <div class="footer-texts-block">
            <?= \Zver\StringHelper::getFooterYears(2008) ?>
            <?= ___('НазваниеФирмыПодвал') ?>
        </div>
        <div class="footer-texts-block">
            <?= ___('ТекстОКомпанииПодвал') ?>
        </div>
    </div>
    <?php
    foreach (\Zver\ArrayHelper::load(Common::getMainItems(false)
                                           ->as_array())
                              ->splitParts(2) as $mainItems) {
        ?>
        <div class="footer-nav">
            <?php
            foreach ($mainItems as $mainItem) {
                ?>
                <a href="<?= $mainItem->getHREF() ?>" class="footer-nav-item">
                    <?= $mainItem->get(Common::getCurrentLang() . '_name') ?>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
    <div class="footer-links">
        <a href="https://er.ru/" class="footer-links-item" target="_blank">
            <img src="/inc/images/er.png" alt="Единая Россия официальный сайт партии">
        </a>
        <a href="https://www.rosminzdrav.ru/" class="footer-links-item" target="_blank">
            <img alt="Министерство здравоохранения Российской Федерации" src="/inc/images/minrf.png">
        </a>
        <a href="http://www.minzdravkk.ru/" class="footer-links-item" target="_blank">
            <img alt="Министерство здравоохранения Краснодарского Края" src="/inc/images/minkuban.png">
        </a>
        <a href="https://onf.ru/" class="footer-links-item" target="_blank">
            <img alt="Общероссийский народный фронт" src="/inc/images/front.png">
        </a>
        <div class="clearfix"></div>
    </div>
</div>
