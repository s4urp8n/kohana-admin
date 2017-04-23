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

function getAssetsVersion()
{
    return file_get_contents(DOCROOT . 'version.txt');
}

function ___($key)
{

    $translate = ORM::factory('Translate')
                    ->where('_key', '=', $key)
                    ->find();

    if (empty($translate->id)) {
        $row = new Model_Translate();
        $row->_key = $key;
        $row->save();
    } else {
        $text = $translate->get(Common::getCurrentLang());
        if (!empty($text)) {
            if ($translate->strip == 1) {
                return strip_tags($text);
            }

            return $text;
        }
    }

    return $key;
}

function getFileContent($path)
{
    return file_get_contents(\Zver\Common::replaceSlashesToPlatformSlashes(DOCROOT . $path));
}

function printDie()
{

    $args = func_get_args();

    foreach ($args as $arg) {
        echo "<pre>";

        if (is_array($arg)) {
            print_r($arg);
        } elseif (is_object($arg)) {
            var_dump($arg);
        } else {
            echo $arg;
        }
        echo "</pre>";
    }
    die();
}

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