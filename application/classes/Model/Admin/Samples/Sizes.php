<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Sizes extends Model_Admin
{
    
    public function getInsertColumns()
    {
        return [
            'tableName' => 'sizes',
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public static function getCommonColumns()
    {
        return [
            'width'   => [
                'label' => 'Ширина',
                'type'  => 'number',
            ],
            'height'  => [
                'label' => 'Высота',
                'type'  => 'number',
            ],
            'price'   => [
                'label' => 'Цена',
                'type'  => 'number',
                'step'  => 0.1,
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
            'tableName' => 'sizes',
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
            'caption' => 'Размеры',
            'icon'    => '<i class="fa fa-crop"></i>',
            'group'   => 'dicts',
        ];
    }
    
    public function deleteData($id = null)
    {
        DB::delete('sizes')
          ->where('id', '=', $id)
          ->execute();
    }
    
    public function getData()
    {
        
        $data = DB::select('id')
                  ->select(['width', 'Ширина'])
                  ->select(['height', 'Высота'])
                  ->select(['price', 'Цена'])
                  ->select(['visible', 'Видимость'])
                  ->from('sizes')
                  ->order_by('width')
                  ->order_by('height');
        
        return $data->execute()
                    ->as_array();
    }
    
}
