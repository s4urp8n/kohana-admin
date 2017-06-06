<a href="<?= $product->getHref() ?>" class="products-product">


    <?php
    $img = $product->getImage();
    ?>

    <img class="products-product-image"

        <?php
        if ($img) {

            $img = ImagePreview::getPreview($img, 200, 200, true, '#ffffff', false);

            ?>
            src="<?= $img ?>"
            <?php
        }
        ?>
    />

    <span class="products-product-title">
        <?= $product->get('title_' . Common::getCurrentLang()) ?>
    </span>

    <span class="products-product-price">
        <?= $product->price ?> руб/<?= ORM::factory('Units')
                                          ->find($product->unit_id)
                                          ->get(Common::getCurrentLang() . '_name') ?>
    </span>

    <button class="products-product-button">
        <?= ___('ЗаказатьКнопка') ?>
    </button>

</a>

