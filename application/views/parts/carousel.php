<?php
$key = 'IndexPageView_wd3dud4f43f' . Common::getCurrentLang();

$generate = function () {
    ob_start();
    $gallery = ORM::factory('IndexGallery')
                  ->where('visible', '=', 1)
                  ->find_all();
    ?>

    <?php
    if ($gallery->count() > 0) {
        ?>
        <div class="fotorama indexGallery"
             data-width="100%"
             data-height="300"
             data-fit="cover"
             data-loop="true"
             data-autoplay="7000"
             data-transition="crossfade"
        >

            <?php
            foreach ($gallery as $galleryImage) {
                $image = $galleryImage->getImage();

                if (!empty($image)) {
                    ?>
                    <div data-img="<?= $image ?>">

                        <?php
                        if (!empty($galleryImage->link)) {
                            ?>
                            <a href="<?= $galleryImage->link ?>" class="fotorama__select">
                                <?=
                                View::factory('parts/carouselPart', [
                                    'caption' => $galleryImage->get(Common::getCurrentLang() . "_caption"),
                                    'image'   => $image,
                                ])
                                ?>
                            </a>
                            <?php
                        } else {
                            ?>
                            <span class="fotorama__select">
                                <?=
                                View::factory('parts/carouselPart', [
                                    'caption' => $galleryImage->get(Common::getCurrentLang() . "_caption"),
                                    'image'   => $image,
                                ])
                                ?>
                            </span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
    ?>

    <?php
    return ob_get_clean();
};

echo \Zver\FileCache::retrieve($key, $generate);
?>