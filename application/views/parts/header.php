<div class="header">
    <div class="page-container">

        <div class="header-row user-select-none">
            <?= View::factory('parts/navigation', ['activeId' => empty($activeId) ? null : $activeId]) ?>

            <div class="header-langs">

                <div class="header-langs-inner">

                    <?= View::factory('parts/langs') ?>

                    <div class="clearfix"></div>

                </div>
                <div class="clearfix"></div>
            </div>

        </div>

    </div>

</div>

<?= View::factory('parts/mobile', ['activeId' => empty($activeId) ? null : $activeId]) ?>

