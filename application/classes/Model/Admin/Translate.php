<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Translate extends Model_Admin
{

    public static function getCommonColumns()
    {
        return [
            '_key'  => [
                'label' => 'Название',
                'type'  => 'text',
            ],
            'en'    => [
                'label' => 'Английский',
                'type'  => 'editor',
            ],
            'ru'    => [
                'label' => 'Русский',
                'type'  => 'editor',
            ],
            'strip' => [
                'label' => 'Убирать теги',
                'type'  => 'bool',
            ],
        ];
    }

    public function deleteData($id = null)
    {
        DB::delete('translate')
                ->where('id', '=', $id)
                ->execute();
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'translate',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getData()
    {

        $data = DB::select()
                ->select('id')
                ->select([
                    '_key',
                    'Название',
                ])
                ->select([
                    'en',
                    'Английский',
                ])
                ->select([
                    'ru',
                    'Русский',
                ])
                ->from('translate')
                ->order_by('_key');

        return $data->execute()
                        ->as_array();
    }

    public function getInfo()
    {
        return [
            'caption' => 'Переводы',
            'icon'    => '<i class="fa fa-globe"></i>',
            'group'   => 'admin',
        ];
    }

}
