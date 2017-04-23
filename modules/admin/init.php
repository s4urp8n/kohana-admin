<?php

defined('SYSPATH') or die('No direct script access.');

$moduleName = basename(__DIR__);

//checking ORM module
if (!class_exists('ORM'))
{
    throw new Exception('ORM module must be enabled in bootstrap.php to using ' . $moduleName . ' module!');
}

//checking Database module
if (!class_exists('DB'))
{
    throw new Exception('Database module must be enabled in bootstrap.php to using ' . $moduleName . ' module!');
}

//routes
$anySymbols = '[^/]+';

Route::set(
    $moduleName . 'Default', $moduleName . '/<action>(/<param>(/<primary>))', [
                               'param'   => $anySymbols,
                               'primary' => $anySymbols,
                           ]
)
     ->defaults(
         [
             'controller' => ucfirst($moduleName),
         ]
     );

