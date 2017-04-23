<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_SecondaryItemsOrder extends Model_Admin_OrderSelect
{

    public function getInfo()
    {
        return [
            'caption' => 'Порядок подкатегорий',
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
            'table'      => 'secondary_items',
            'column'     => 'ru_name',
            'sortColumn' => 'sort',
            'conditions' => [],
        ];
    }

    public function getOrderSelectData()
    {

        $sql =
            'SELECT id,ru_name FROM `main_items` where EXISTS(select id from secondary_items where main_item_id=main_items.id) order by ru_name';

        $categories = DB::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array('id', 'ru_name');

        return [
            'column'        => 'main_item_id',
            'selectCaption' => 'Выберите категорию:',
            'values'        => $categories,
        ];
    }

    public function isVisible()
    {
        return (ORM::factory('SecondaryItem')
                   ->find_all()
                   ->count() > 1);
    }

}
