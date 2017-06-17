<?php
$noInteract = !empty($noInteract);
?>
<div class="cartTable">
    <table class="table table-bordered table-responsive">
        <tr>
            <th>№</th>
            <th colspan="2"><?= ___('ТоварКорзина') ?></th>
            <th><?= ___('КоличествоКорзина') ?></th>
            <th><?= ___('ЦенаКорзина') ?></th>
            <?php
            if (!$noInteract) {
                ?>
                <th></th>
                <?php
            }
            ?>
        </tr>
        <?php
        $good = null;
        $index = 1;
        $totalSum = 0;
        $totalCount = 0;
        foreach ($cart as $item) {
            $good = ORM::factory('Goods')
                       ->where('id', '=', $item['id'])
                       ->find();

            if (!empty($good->id)) {
                $identity = Modules::getCartIdentity($good->id);
                ?>
                <tr>
                    <td>
                        <?= $index++ ?>
                    </td>
                    <td>
                        <a href="<?= $good->getHREF() ?>"
                           class="goodA"
                           target="_blank">
                            <img src="<?= Common::makeFullPathShared($good->getImage()) ?>">
                        </a>
                    </td>
                    <td>
                        <a href="<?= $good->getHREF() ?>"
                           class="goodA"
                           target="_blank">
                            <?= $good->get('title_' . Common::getCurrentLang()) ?>
                        </a>
                    </td>
                    <td>
                        <?php
                        if (!is_numeric($item['count']) || $item['count'] < 0) {
                            $item['count'] = 1;
                        }
                        ?>

                        <?php

                        $value = $item['count'] . ' ' . ORM::factory('Units')
                                                           ->find($good->unit_id)
                                                           ->get(Common::getCurrentLang() . '_name');

                        if ($noInteract) {
                            echo $value;
                        } else {
                            ?>
                            <div class="numberChanger">
                                <ul class="pagination">
                                    <li>
                                        <a class="dec"
                                           href="/ajax/dec?id=<?= $identity ?>&ref=<?= urlencode(AdminHREF::getFullCurrentHREF()) ?>">
                                            -
                                        </a>
                                    </li>
                                    <li class="active">
                                        <span><?= $value ?></span>
                                    </li>
                                    <li>
                                        <a class="inc"
                                           href="/ajax/inc?id=<?= $identity ?>&ref=<?= urlencode(AdminHREF::getFullCurrentHREF()) ?>">
                                            +
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <?php
                        }

                        ?>
                        <?php
                        $totalCount += $item['count'];
                        ?>
                    </td>
                    <td class="cartPrice" price="<?= $item['price'] ?>">
                        <?= $item['price'] * $item['count'] ?><?php
                        $totalSum += $item['price'] * $item['count'];
                        ?>
                    </td>

                    <?php
                    if (!$noInteract) {
                        ?>
                        <td>
                            <a href="/ajax/remove?id=<?= $identity ?>&ref=<?= urlencode(AdminHREF::getFullCurrentHREF()) ?>"
                               class="btn btn-danger btn-remove">

                                <?= ___('Удалить из корзины') ?>

                            </a>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
        }
        ?>

        <tr>
            <td colspan="3" style="text-align: right">
                <?= ___('ИтогоКорзина') ?>:
            </td>
            <td class="cartTotalCount">
                <?= $totalCount ?>
            </td>
            <td class="cartTotalSum">
                <?= $totalSum ?>
            </td>

            <?php
            if (!$noInteract) {
                ?>
                <td></td>
                <?php
            }
            ?>
        </tr>

    </table>


</div>
