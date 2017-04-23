<?php

defined('SYSPATH') or die('No direct script access.');

return [
    // Application defaults
    'default' => [
        // source: "query_string" or "route"
        'current_page'      => ['source' => 'query_string', 'key' => 'page'],
        'total_items'       => 0,
        'items_per_page'    => 20,
        'view'              => 'pagination/basic',
        'auto_hide'         => true,
        'first_page_in_url' => false,
        //if use limited template
        'max_left_pages'    => 4,
        'max_right_pages'   => 4,
    ],
];
