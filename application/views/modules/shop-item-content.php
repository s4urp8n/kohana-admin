<div class="content-block content-block--with-panel">

    <?= View::factory('modules/shop-categories') ?>

    <div class="content-block-content shop-item-content">

        <div class="content-block-content-left">

            <?php
            $img = $product->getImage();

            if (empty($img)) {
                $img = '';
            } else {
                $img = ImagePreview::getPreview($img, 500, 500, true, '#ffffff', false);
            }

            ?>

            <img src="<?= $img ?>" alt="" class="shop-item-content-img--big"/>


        </div>
        <div class="content-block-content-right">

            <div class="shop-item-content-title">
                <?= $product->get('title_' . Common::getCurrentLang()) ?>
            </div>

            <div class="shop-item-content-description">
                <?= $product->get('description_' . Common::getCurrentLang()) ?>
            </div>

            <form class="shop-item-content-order-form" action="" method="post">

                <label class="shop-item-content--count">
                    <span class="label"><?= ___('КоличествоТовара') ?></span>
                    <input class="input" type="number" value="1"/>
                    <span class="clearfix"></span>
                </label>

                <label class="shop-item-content-price">
                    <span class="label"><?= ___('ЦенаТовара') ?></span>
                    <span class="shop-item-content-price-price input">
                        <?= $product->price ?>
                    </span>
                    <span class="clearfix"></span>
                </label>

                <label class="shop-item-content-total">
                    <span class="label">
                        <?= ___('ИтогоТовар') ?>
                    </span>
                    <span class="shop-item-content-total-total input">
                       <?= $product->price ?>
                    </span>
                    <span class="clearfix"></span>
                </label>

                <button class="shop-item-content-order-form-submit" type="submit">
                    <i class="fa fa-cart-plus"></i> <?= ___('ВКорзинуКнопка') ?>
                </button>

            </form>

        </div>

        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>

</div>