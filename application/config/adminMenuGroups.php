<?php

defined('SYSPATH') OR die('No direct script access.');

$config = [
    'content' => [
        'name' => ' Содержимое',
        'icon' => '<i class="fa fa-paper"></i>',
    ],
    'order'   => [
        'name' => ' Изменение порядка',
        'icon' => '<i class="fa fa-sort"></i>',
    ],
    'upload'  => [
        'name' => ' Загрузки на сайт',
        'icon' => '<i class="fa fa-upload"></i>',
    ],
    'admin'   => [
        'name' => ' Администрирование',
        'icon' => '<i class="fa fa-unlock"></i>',
    ],
];

return $config;
