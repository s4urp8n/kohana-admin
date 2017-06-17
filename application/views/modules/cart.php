<?php
$cart = Cart::get();
$href = Common::getShopMainItem();

if (empty($cart)) {
    ?>

    <?php
    if (!empty($_GET['success'])) {
        ?>
        <div class="alert alert-info">
            <?= ___('ВашЗаказУспешноДобавлен') ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-info">
            <?= ___('Корзина пуста') ?>.

            <a href="<?= $href->getHref() ?>">
                <?= ___('ВоспользуйтесьКаталогомДляПоискаИПокупки') ?>
            </a>
        </div>
        <?php
    }
    ?>


    <?php
} else {

    ?>

    <h3>
        <?= ___('Корзина') ?>
    </h3>

    <?= View::factory('modules/cartTable', [
        'cart' => Cart::get(),
    ]) ?>

    <div class="cart-order-block">
        <?php
        if (Auth::instance()
                ->logged_in('user')
        ) {
            ?>

            <a class="btn btn-danger btn-block shop-item-content-order-form-submit"
               href="/<?= Common::getCurrentLang() ?>/order">

                <?= ___('ОформитьЗаказКнопка') ?>

            </a>

            <?php
        } else {
            ?>

            <div class="alert alert-info">

                <?= ___('Для оформления заказа необходимо авторизоваться или зарегистрироваться на сайте') ?>

                <br>

                <a class="shop-item-content-order-form-submit" href="/admin/auth?lang=<?= Common::getCurrentLang() ?>">
                    <?= ___('ВойтиТекст') ?>
                </a>

                <a class="shop-item-content-order-form-submit"
                   href="/admin/register?lang=<?= Common::getCurrentLang() ?>">
                    <?= ___('РегистрацияТекст') ?>
                </a>

            </div>

            <?php
        }
        ?>

    </div>

    <?php
}
?>