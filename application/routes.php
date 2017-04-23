<?php

defined('SYSPATH') or die('No direct script access.');

Route::set('admin', 'admin')
     ->defaults(['controller' => 'admin', 'action' => 'menu',]);

Route::set('articles', '<lang>/articles/<id>-(<name>)', [
    'id'   => '\d+',
    'name' => '[^/]+',
    'lang' => 'ru|en',
])
     ->defaults(['controller' => 'articles', 'action' => 'index',]);

Route::set('news', '<lang>/news/<id>-(<name>)', [
    'lang' => 'ru|en',
    'id'   => '\d+',
    'name' => '[^/]+',
])
     ->defaults(['controller' => 'news', 'action' => 'index',]);

Route::set('default', '(<lang>(/<main_item>(/<secondary_item>)))', [
    'lang'           => 'ru|en',
    'main_item'      => '[^/]+',
    'secondary_item' => '[^/]+',
])
     ->defaults([
                    'controller' => 'welcome',
                    'action'     => 'index',
                ]);
