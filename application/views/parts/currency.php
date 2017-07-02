<div class="currencies" default="<?= Common::getDefaultCurrency() ?>">

    <?php

    $currencies = array_keys(Model_Admin_Currency::getCommonColumns());

    foreach ($currencies as $currency) {

        if ($currency != Common::getDefaultCurrency()) {
            ?>
            <span class="currency" ratio="<?= Common::getCurrencyRatio($currency) ?>">


                <?php

                $label = \Zver\StringHelper::load($currency)
                                           ->toUpperCase()
                                           ->get();

                if ($label == 'RUB') {
                    $label = '&#8381;';
                } elseif ($label == 'EUR') {
                    $label = '&#8364;';
                } elseif ($label == 'USD') {
                    $label = '&#36;';
                }

                ?>

                <?= Common::getCurrencyValue($currency, $sum) . $label ?>

            </span>
            <?php
        }
    }

    ?>

</div>