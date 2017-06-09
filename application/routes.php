<?php

defined('SYSPATH') or die('No direct script access.');

$langs = implode('|', Common::getLangs());

Route::set('admin', 'admin')
     ->defaults([
                    'controller' => 'admin',
                    'action'     => 'menu',
                ]);

Route::set('articles', '<lang>/articles/<id>-(<name>)', [
    'id'   => '\d+',
    'name' => '[^/]+',
    'lang' => $langs,
])
     ->defaults([
                    'controller' => 'articles',
                    'action'     => 'index',
                ]);

Route::set('news', '<lang>/news/<id>-(<name>)', [
    'id'   => '\d+',
    'name' => '[^/]+',
    'lang' => $langs,
])
     ->defaults([
                    'controller' => 'news',
                    'action'     => 'index',
                ]);

Route::set('good', '<lang>/good/<id>-(<name>)', [
    'id'   => '\d+',
    'name' => '[^/]+',
    'lang' => $langs,
])
     ->defaults([
                    'controller' => 'product',
                    'action'     => 'index',
                ]);

Route::set('article', '<lang>/article/<id>-(<name>)', [
    'id'   => '\d+',
    'name' => '[^/]+',
    'lang' => $langs,
])
     ->defaults([
                    'controller' => 'article',
                    'action'     => 'index',
                ]);

Route::set('default', '(<lang>(/<main_item>(/<secondary_item>)))', [
    'main_item'      => '[^/]+',
    'secondary_item' => '[^/]+',
    'lang'           => $langs,
])
     ->defaults([
                    'controller' => 'welcome',
                    'action'     => 'index',
                ]);

