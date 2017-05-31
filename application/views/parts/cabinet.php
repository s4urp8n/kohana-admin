<?php

if (Auth::instance()
        ->logged_in('admin')
) {
    Auth::instance()
        ->logout();

    Common::redirect('/');
}

$cabinetMenu = [
    'profile' => [
        'title' => ___('Мой профиль'),
        'view'  => 'parts/cabinet/profile',
    ],
    'orders'  => [
        'title' => ___('Мои заказы'),
        'view'  => 'parts/cabinet/orders',
    ],
    'logout'  => [
        'title'    => ___('Выйти'),
        'callback' => function () {

            Auth::instance()
                ->logout();

            Common::redirect('/');

        },
    ],
];

$currentMenu = \Zver\ArrayHelper::load($cabinetMenu)
                                ->getFirstKey();

$request = Request::initial();

$menu = $request->query('menu');

if (!empty($menu) && in_array($menu, array_keys($cabinetMenu))) {
    $currentMenu = $menu;
}

$currentData = $cabinetMenu[$currentMenu];

if (array_key_exists('callback', $currentData)) {
    call_user_func($currentData['callback']);
}

?>

<div class="content-block content-block--with-panel">

    <div class="content-block-panel">
        <?php

        foreach ($cabinetMenu as $menuKey => $menuItem) {

            $class = 'content-block-panel-item';

            if ($currentMenu == $menuKey) {
                $class = $class . ' ' . $class . "--active";
            }

            ?>
            <a href="<?= AdminHREF::getFullCurrentHREF(['menu'], ['menu' => $menuKey]) ?>"
               class="<?= $class ?>">
                <?= $menuItem['title'] ?>
            </a>
            <?php
        }
        ?>
    </div>


    <div class="content-block-content">

        <?php
        if (array_key_exists('view', $currentData)) {
            echo View::factory($currentData['view']);
        }
        ?>

    </div>

    <div class="clearfix"></div>

</div>