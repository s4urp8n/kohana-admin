<?php

$application = 'application';

$modules = 'modules';

$system = 'system';

define('EXT', '.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DOCROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

if (!is_dir($application) AND is_dir(DOCROOT . $application)) {
    $application = DOCROOT . $application;
}

if (!is_dir($modules) AND is_dir(DOCROOT . $modules)) {
    $modules = DOCROOT . $modules;
}

if (!is_dir($system) AND is_dir(DOCROOT . $system)) {
    $system = DOCROOT . $system;
}

define('APPPATH', realpath($application) . DIRECTORY_SEPARATOR);
define('MODPATH', realpath($modules) . DIRECTORY_SEPARATOR);
define('SYSPATH', realpath($system) . DIRECTORY_SEPARATOR);

unset($application, $modules, $system, $composer);

require APPPATH . 'bootstrap' . EXT;

if (AdminHREF::getSubdomain() == 'dev') {
    define('DEV', true);
    define('PRODUCTION', false);
} else {
    define('DEV', false);
    define('PRODUCTION', true);
}

if (PHP_SAPI == 'cli') {
    class_exists('Minion_Task') OR die('Please enable the Minion module for CLI support.');
    set_exception_handler(['Minion_Exception', 'handler']);
    Minion_Task::factory(Minion_CLI::options())
               ->execute();
} else {
    $request = Request::factory(true, [], false)
                      ->execute()
                      ->send_headers(true)
                      ->body();

    $request = \Zver\StringHelper::load($request)
                                 ->trimSpaces();

    echo $request;
}

