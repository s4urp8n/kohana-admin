<?php

defined('SYSPATH') OR die('No direct access allowed.');

return [
    'default' => [
        'type'         => 'PDO',
        'connection'   => [
            'dsn'        => 'mysql:host=localhost;dbname=<DATABASE>',
            'username'   => '<DATABASE_USERNAME>',
            'password'   => '<DATABASE_PASSWORD>',
            'persistent' => false,
            'options'    => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8;'],
        ],
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => false,
    ],
];
