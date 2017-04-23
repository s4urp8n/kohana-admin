<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Pasports extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName' => 'pasports',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public static function getCommonColumns()
    {
        return [
            'color'   => [
                'label' => 'Цвет',
                'type'  => 'color',
            ],
            'visible' => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'pasports',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Паспорту',
            'icon'    => '<i class="fa fa-th-list"></i>',
            'group'   => 'dicts',
        ];
    }

    public function deleteData($id = null)
    {
        DB::delete('pasports')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['color', 'Цвет'])
                  ->select(
                      [
                          'visible',
                          'Видимость',
                      ]
                  )
                  ->from('pasports')
                  ->order_by('color');

        return $data->execute()
                    ->as_array();
    }

}
