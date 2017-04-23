<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Types extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName' => 'types',
            'validate'  => $this->getValidatePost(),
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getValidatePost()
    {
        return function ($post) {
            if (empty($post['name'])) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public static function getCommonColumns()
    {
        return [
            'name'    => [
                'label' => 'Название',
                'type'  => 'text',
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
            'tableName' => 'types',
            'primary'   => 'id',
            'validate'  => $this->getValidatePost(),
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
            'caption' => 'Типы',
            'icon'    => '<i class="fa fa-tags"></i>',
            'group'   => 'dicts',
        ];
    }

    public function deleteData($id = null)
    {
        DB::delete('types')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['name', 'Название'])
                  ->select(
                      [
                          'visible',
                          'Видимость',
                      ]
                  )
                  ->from('types')
                  ->order_by('name');

        return $data->execute()
                    ->as_array();
    }

}
