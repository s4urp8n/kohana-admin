<div class="mobile-navigation user-select-none">

    <a href="/" class="mobile-navigation__logo">
        <img src="/inc/images/logo-m.svg" alt="logo" class="mobile-navigation__logo__img"/>
    </a>

    <input id="mobile-navigation__checkbox" type="checkbox" class="mobile-navigation__checkbox">

    <label for="mobile-navigation__checkbox" class="mobile-navigation__checkbox__label">
        <span class="mobile-navigation__checkbox__label__bar"></span>
        <span class="mobile-navigation__checkbox__label__bar"></span>
        <span class="mobile-navigation__checkbox__label__bar"></span>
    </label>

    <div class="mobile-navigation__content">

        <div class="mobile-navigation__langs">
            <?= View::factory('parts/langs', ['noreverse' => 1]) ?>
        </div>

        <?= View::factory('parts/navigation', [
            'mobile'   => true,
            'activeId' => empty($activeId) ? null : $activeId,
        ]) ?>

    </div>

</div>

