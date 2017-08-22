<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_ShopCategories extends Model_Admin
{

    protected static $tableName = 'shop_categories';

    public function getInsertColumns()
    {
        return [
            'tableName' => static::$tableName,
            'columns'   => self::getCommonColumns(),
            'validate'  => $this->getValidatePost(),
        ];
    }

    public static function getRecursiveCategories()
    {
        $list = Model_ShopCategories::getList();

        $data = [];

        $list->walk(function ($item) use (&$data) {
            $data[] = [
                'id'      => $item->getId(),
                'name'    => implode(' > ', $item->getRecursiveDataProperty('ru_name')),
                'visible' => $item->getDataProperty('visible'),
            ];
        });

        return $data;
    }

    public static function getCommonColumns()
    {
        $options = [null => null];

        \Zver\ArrayHelper::load(static::getRecursiveCategories())
                         ->map(function ($value, $key) use (&$options) {
                             $options[$value['id']] = $value['name'];
                         })
                         ->get();

        return [
            'id_parent'      => [
                'label'   => 'Родительская категория',
                'type'    => 'select',
                'options' => [null => null] + $options,
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
            'ru_title'       => [
                'label' => 'titleRU',
                'type'  => 'textarea',
            ],
            'en_title'       => [
                'label' => 'titleEN',
                'type'  => 'textarea',
            ],
            'am_title'       => [
                'label' => 'titleAM',
                'type'  => 'textarea',
            ],
            'ru_keywords'    => [
                'label' => 'keywordsRU',
                'type'  => 'textarea',
            ],
            'en_keywords'    => [
                'label' => 'keywordsEN',
                'type'  => 'textarea',
            ],
            'am_keywords'    => [
                'label' => 'keywordsAM',
                'type'  => 'textarea',
            ],
            'ru_description' => [
                'label' => 'descriptionRU',
                'type'  => 'textarea',
            ],
            'en_description' => [
                'label' => 'descriptionEN',
                'type'  => 'textarea',
            ],
            'am_description' => [
                'label' => 'descriptionAM',
                'type'  => 'textarea',
            ],
            'visible'        => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
            'image'          => [
                'label' => 'Картинка',
                'type'  => 'textarea',
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

    public function __construct()
    {

        if (!empty($_POST) && empty($_POST['id_parent'])) {
            $_POST['id_parent'] = null;
        }

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
            'caption' => 'Категории товаров',
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

        return static::getRecursiveCategories();
    }

}
