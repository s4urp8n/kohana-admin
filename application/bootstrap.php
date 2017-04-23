<?php

defined('SYSPATH') or die('No direct script access.');

require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'));

require "functions.php";
require SYSPATH . 'classes/Kohana/Core' . EXT;

if (is_file(APPPATH . 'classes/Kohana' . EXT)) {
    require APPPATH . 'classes/Kohana' . EXT;
} else {
    require SYSPATH . 'classes/Kohana' . EXT;
}

date_default_timezone_set('Europe/Moscow');

setlocale(LC_ALL, 'en_US.utf-8');

spl_autoload_register(['Kohana', 'auto_load']);

ini_set('unserialize_callback_func', 'spl_autoload_call');

mb_substitute_character('none');

I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL'])) {
    HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

Kohana::$environment = Kohana::PRODUCTION;

Kohana::init(
    [
        'base_url'   => '/',
        'index_file' => false,
        'errors'     => true,
    ]
);

Cookie::$salt = "mKNB&F(T*фываьц3а23прафыадьзвGHMP<";

\Zver\FileCache::setDirectory(APPPATH . 'cache' . DIRECTORY_SEPARATOR);

Kohana::$log->attach(new Log_File(APPPATH . 'logs'));

Kohana::$config->attach(new Config_File);

Kohana::modules(
    [
        'auth'       => MODPATH . 'auth',
        'database'   => MODPATH . 'database',
        'image'      => MODPATH . 'image',
        'orm'        => MODPATH . 'orm',
        'admin'      => MODPATH . 'admin',
        'yandexmap'  => MODPATH . 'yandexmap',
        'minion'     => MODPATH . 'minion',
        'captcha'    => MODPATH . 'captcha',
        'pagination' => MODPATH . 'pagination',
    ]
);

include_once 'routes.php';