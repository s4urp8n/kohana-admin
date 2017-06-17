<?php

$orders = ORM::factory('Orders')
             ->where('user_id', '=', Auth::instance()
                                         ->get_user()->id)
             ->order_by('date', 'desc')
             ->order_by('time', 'desc')
             ->find_all()
             ->as_array();

?>

<?php

if ($orders) {
    ?>

    <?php
    foreach ($orders as $order) {
        ?>

        <h4><?= ___('Заказ') ?> № <?= $order->id ?></h4>

        <div>

            <span>
                <?= ___('ДатаЗаказа') ?>
                :
                <?= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->date . ' ' . $order->time)
                                  ->format('Y-m-d H:i:s') ?></span>

            &nbsp;
            &nbsp;
            &nbsp;

            <span>
                <?= ___('СтатусЗаказа') ?>
                :
                <?= Common::getOrderStatuses()[$order->status] ?>
            </span>
            <br>
            <br>
        </div>

        <?= View::factory('modules/cartTable', [
            'cart'       => json_decode($order->cart, true),
            'noInteract' => 1,
        ]) ?>

        <br>
        <br>

        <?php
    }

    ?>


    <?php
} else {
    ?>

    <div class="alert alert-info">
        <?= ___('ЗаказавПокаНетТекст') ?>
    </div>

    <?php
}
