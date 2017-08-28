<?= View::factory('parts/breads') ?>

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

            <?php

            $images = $product->getGalleryImages();

            echo View::factory('parts/photos', [
                'images' => $images,
            ]);

            ?>


        </div>
        <div class="content-block-content-right">

            <div class="shop-item-content-title">
                <?= $product->get('title_' . Common::getCurrentLang()) ?>
            </div>

            <div class="shop-item-content-description">
                <?= $product->get('description_' . Common::getCurrentLang()) ?>
            </div>

            <?php
            if (Cart::in(Modules::getCartIdentity($product->id))) {

                ?>
                <a href="<?= Common::getCartMainItem()
                                   ->getHref() ?>" class="shop-item-content-order-form-submit">

                    <i class="fa fa-shopping-cart"></i>
                    <?= ___('УжеВКорзинеКнопка') ?>

                </a>
                <?php

            } else {

                ?>
                <form class="shop-item-content-order-form"
                      action="/ajax/buy"
                      method="get"
                >

                    <label class="shop-item-content--count">
                        <span class="label"><?= ___('КоличествоТовара') ?></span>
                        <input class="input" name='count' type="number" min="1" max="50" value="1"/>
                        <span class="clearfix"></span>
                    </label>

                    <label class="shop-item-content-price">
                        <span class="label"><?= ___('ЦенаТовара') ?></span>
                        <span class="shop-item-content-price-price input">
                        <?= $product->price ?> <?= Common::getDefaultCurrency() ?>
                    </span>
                        <span class="clearfix"></span>
                    </label>

                    <label class="shop-item-content-total">
                        <span class="label">
                            <?= ___('ИтогоТовар') ?>
                        </span>
                        <span class="shop-item-content-total-total input">
                            <?= $product->price ?> <?= Common::getDefaultCurrency() ?>
                            <?= View::factory('parts/currency', ['sum' => $product->price]) ?>
                        </span>
                        <span class="clearfix"></span>
                    </label>

                    <button class="shop-item-content-order-form-submit" type="submit">
                        <i class="fa fa-shopping-cart"></i> <?= ___('ВКорзинуКнопка') ?>
                    </button>

                    <input type="hidden" name="ref"
                           value="<?= AdminHREF::getFullCurrentHREF(['id', 'count', 'ref']) ?>"/>
                    <input type="hidden" name="id" value="<?= $product->id ?>"/>

                </form>
                <?php

            }

            ?>


        </div>

        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>

</div>