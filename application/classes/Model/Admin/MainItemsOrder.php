<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_MainItemsOrder extends Model_Admin_Order
{

    public function getInfo()
    {
        return [
            'caption' => 'Порядок главного меню',
            'icon'    => '<i class="fa fa-sort"></i>',
            'group'   => 'order',
        ];
    }

    public function getAllowedRoles()
    {
        return ['admin'];
    }

    public function getOrderData()
    {
        return [
            'primary'    => 'id',
            'table'      => 'main_items',
            'column'     => 'ru_name',
            'sortColumn' => 'sort',
        ];
    }

    public function isVisible()
    {
        return (ORM::factory('MainItem')
                   ->find_all()
                   ->count() > 1);
    }

}
