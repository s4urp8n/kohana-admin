<!DOCTYPE html>
<?php
$currentMainItem = Common::getCurrentMainItem();

$htmlClass = '';
$moduleOptions = Modules::getOptions($currentMainItem);

if (!empty($moduleOptions['no_content'])) {
    $htmlClass = 'no_content';
}

if (!empty($moduleOptions['html_class'])) {
    $htmlClass = $htmlClass . ' ' . $moduleOptions['html_class'];
}

switch (Common::getCurrentColor()) {
    case Common::COLOR_BLUE: {
        $htmlClass .= ' blue_color';
        break;
    }
    case Common::COLOR_YELLOW: {
        $htmlClass .= ' yellow_color';
        break;
    }
    default: {
        $htmlClass .= ' green_color';
    }
}

?>
<html lang="<?= Common::getCurrentLang() ?>" class="<?= $htmlClass ?>">
<head>

    <meta name="robots" content="all"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    if (!empty($description)) {
        ?>
        <meta name="description"
              content="<?= \Zver\StringHelper::load($description)
                                             ->toHTMLEntities()
                                             ->get() ?>"/>
        <?php
    }
    ?>

    <?php
    if (!empty($author)) {
        ?>
        <meta name="description"
              content="<?= \Zver\StringHelper::load($author)
                                             ->toHTMLEntities()
                                             ->get() ?>"/>
        <?php
    }
    ?>

    <?php
    if (!empty($keywords)) {
        ?>
        <meta name="keywords"
              content="<?= \Zver\StringHelper::load($keywords)
                                             ->toHTMLEntities()
                                             ->get() ?>"/>
        <?php
    }
    ?>

    <?php
    if (!empty($title)) {
        ?>
        <title><?= \Zver\StringHelper::load($title)
                                     ->toHTMLEntities()
                                     ->get() ?></title>

        <meta name="title" content="<?= \Zver\StringHelper::load($title)
                                                          ->toHTMLEntities()
                                                          ->get() ?>"/>
        <?php
    }
    ?>

    <link href="/inc/build/<?= getAssetsVersion() ?>.css" rel="stylesheet">
    <script src="/inc/build/<?= getAssetsVersion() ?>.js"></script>

</head>

<body>
<div class="wrapper">
    <div class="wrapper-top">
        <?php
        if (!empty($header)) {
            echo $header;
        }
        ?>

        <?= View::factory('parts/big-bread') ?>

        <div class="page-container">
            <?php
            if (!empty($content)) {
                echo $content;
            }
            ?>
        </div>
    </div>
    <div class="wrapper-bottom">
        <?php
        if (!empty($footer)) {
            echo $footer;
        }
        ?>
    </div>
</div>
</body>
</html>