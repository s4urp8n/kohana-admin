<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Currency extends Model_Admin
{

    public static function getCommonColumns()
    {
        return [
            'amd' => [
                'label' => 'AMD',
                'type'  => 'number',
                'step'  => 0.00000001,
            ],
            'rub' => [
                'label' => 'RUB',
                'type'  => 'number',
                'step'  => 0.00000001,
            ],
            'usd' => [
                'label' => 'USD',
                'type'  => 'number',
                'step'  => 0.00000001,
            ],
            'eur' => [
                'label' => 'EUR',
                'type'  => 'number',
                'step'  => 0.00000001,
            ],
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'currency',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('dataEdit', $this->getShortName(), 1)
               . "?ref=" . urlencode(AdminHREF::getFullHost() . '/admin/menu');
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('currency')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {
        return [];
    }

    public function getInfo()
    {
        return [
            'caption' => 'Курсы валют',
            'icon'    => '<i class="fa fa-usd"></i>',
            'group'   => 'content',
        ];
    }

}
