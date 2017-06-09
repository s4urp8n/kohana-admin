<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Articles extends Model_Admin
{

    protected static $tableName = 'articles';

    public function getInsertColumns()
    {
        return [
            'tableName' => static::$tableName,
            'columns'   => self::getCommonColumns(),
            'validate'  => $this->getValidatePost(),
        ];
    }

    public static function getCommonColumns()
    {
        return [
            'id_category'    => [
                'label'   => 'Категория',
                'type'    => 'select',
                'options' => DB::select('id', 'ru_name')
                               ->from('articles_categories')
                               ->execute()
                               ->as_array('id', 'ru_name'),
            ],
            'ru_name'        => [
                'label' => 'Название менюRU',
                'type'  => 'text',
            ],
            'en_name'        => [
                'label' => 'Название менюEN',
                'type'  => 'text',
            ],
            'am_name'        => [
                'label' => 'Название менюAM',
                'type'  => 'text',
            ],
            'ru_description' => [
                'label' => 'ТекстRU',
                'type'  => 'editor',
            ],
            'en_description' => [
                'label' => 'ТекстEN',
                'type'  => 'editor',
            ],
            'am_description' => [
                'label' => 'ТекстAM',
                'type'  => 'editor',
            ],
            'visible'        => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getValidatePost()
    {
        return function ($post) {
            if (
                empty($post['ru_name']) ||
                empty($post['am_name']) ||
                empty($post['en_name'])
            ) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public function getEditData($primary)
    {
        return [
            'validate'  => $this->getValidatePost(),
            'tableName' => static::$tableName,
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
            'caption' => 'Публикации',
            'icon'    => '<i class="fa fa-book"></i>',
            'group'   => 'content',
        ];
    }

    public function deleteData($id = null)
    {
        DB::delete(static::$tableName)
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {
        $data = DB::select('id')
                  ->select(['ru_name', 'Публикация'])
                  ->from(static::$tableName)
                  ->order_by('ru_name');

        return $data->execute()
                    ->as_array();
    }

}
