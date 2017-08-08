<div class="footer user-select-none">

    <div class="page-container">


        <?=View::factory('parts/social')?>


        <div class="footerRights">

            <div class="footerRights-left">
                <?= getFileContent('inc/images/lusin_group_white.svg') ?>
            </div>

            <div class="footerRights-right">
                <p>
                    &copy;<?= \Zver\StringHelper::getFooterYears(2008) ?>
                    <?= ___('НазваниеФирмыПодвал') ?>
                </p>
                <p><?= Settings::get('contact_phone') ?></p>
                <p><?= Settings::get('contact_email') ?></p>
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>
</div>
