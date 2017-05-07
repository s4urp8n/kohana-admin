<div class="photobox">

    <?php
    if (empty($w)) {
        $w = 100;
    }

    if (empty($h)) {
        $h = 100;
    }
    ?>

    <div class="photobox_container">

        <?php
        if (!empty($videos)) {

            foreach ($videos as $video) {
                ?>
                <a href="http://www.youtube.com/embed/<?php echo $video; ?>" rel="video">
                    <img width='<?php echo $w; ?>'
                         height='<?php echo $h; ?>'
                         src="http://img.youtube.com/vi/<?php echo $video; ?>/0.jpg"/>
                </a>
                <?php
            }
        }
        ?>

        <?php
        if (!empty($images)) {

            foreach ($images as $image) {
                ?>
                <a href="<?php echo $image; ?>">
                    <img width='<?php echo $w; ?>'
                         height='<?php echo $h; ?>'
                         title='<?php echo Upload::getDescription($image); ?>'
                         src="<?php echo ImagePreview::getPreview($image, $w, $h, true, '#ffffff', true); ?>"/>
                </a>
                <?php
            }
        }
        ?>

        <div class='clearfix'></div>
    </div>
</div>