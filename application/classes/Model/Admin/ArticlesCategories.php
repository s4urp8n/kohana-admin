<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_ArticlesCategories extends Model_Admin
{

    protected static $tableName = 'articles_categories';

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
            'ru_name' => [
                'label' => 'Название менюRU',
                'type'  => 'text',
            ],
            'en_name' => [
                'label' => 'Название менюEN',
                'type'  => 'text',
            ],
            'am_name' => [
                'label' => 'Название менюAM',
                'type'  => 'text',
            ],
            'visible' => [
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
            'caption' => 'Категории публикаций',
            'icon'    => '<i class="fa fa-list-alt"></i>',
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
                  ->select(['ru_name', 'Категория'])
                  ->from(static::$tableName)
                  ->order_by('ru_name');

        return $data->execute()
                    ->as_array();
    }

}
