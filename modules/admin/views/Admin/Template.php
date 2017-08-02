<?php
if (isset($bodyClass)) {
    $bodyClass = 'class="' . $bodyClass . '"';
} else {
    $bodyClass = '';
}
?>

<?php

\Zver\Common::removeDirectoryContents(\Zver\FileCache::getDirectory());

touch(\Zver\StringHelper::load(\Zver\FileCache::getDirectory())
                        ->ensureEndingIs(DIRECTORY_SEPARATOR)
                        ->append('.gitkeep')
                        ->get());

header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en" <?= $bodyClass ?>>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    if (!empty($title)) {
        ?>
        <title><?php echo $title; ?></title>
        <?php
    }
    ?>

    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <?php
    $styles = [
        '/inc/build/' . getAssetsVersion() . '.css',
        '/' . Admin::getConfig('sharedDir') . '/css/' . getAssetsVersion() . '.css',
    ];
    ?>

    <?php foreach ($styles as $style) {
        ?>

        <link rel="stylesheet" href="<?= $style ?>">

        <?php
    }
    ?>

    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery-1.10.2.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/bootstrap.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery.sumoselect.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery.uploadfile.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery.browser.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jscolor/jscolor.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/youtube.js"></script>
    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/hex_md5.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/image-picker/image-picker.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/summernote/dist/summernote.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/tag-it-master/js/tag-it.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/jquery.switcher/switcher.min.js"></script>
    <script src="/<?php echo Admin::getConfig('sharedDir'); ?>/js/script.js"></script>

</head>

<body <?= $bodyClass ?>>
<?php
if (!empty($content)) {
    echo $content;
}
?>
</body>
</html>
