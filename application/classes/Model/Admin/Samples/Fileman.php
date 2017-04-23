<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Fileman extends Model_Admin
{

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('fileman', 'Fileman');
    }

    public function getInfo()
    {
        return [
            'caption' => 'Файловый менеджер',
            'icon'    => '<i class="fa fa-pencil-square-o"></i>',
            'group'   => 'upload',
        ];
    }

}
