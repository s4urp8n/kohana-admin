<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_MainItems extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName' => 'main_items',
            'validate'  => $this->getValidatePost(),
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getValidatePost()
    {
        return function ($post) {
            if (empty($post['ru_name']) || empty($post['en_name'])) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public static function getCommonColumns()
    {
        return [
            'ru_name'        => [
                'label' => 'КатегорияRU',
                'type'  => 'text',
            ],
            'en_name'        => [
                'label' => 'КатегорияEN',
                'type'  => 'text',
            ],
            'am_name'        => [
                'label' => 'КатегорияAM',
                'type'  => 'text',
            ],
            'ru_content'     => [
                'label' => 'СодержаниеRU',
                'type'  => 'editor',
            ],
            'en_content'     => [
                'label' => 'СодержаниеEN',
                'type'  => 'editor',
            ],
            'am_content'     => [
                'label' => 'СодержаниеAM',
                'type'  => 'editor',
            ],
            'module'         => [
                'label'   => 'Модуль',
                'type'    => 'select',
                'options' => Modules::getModulesKeys(),
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
            'go_child'       => [
                'label' => 'Переходить на первую дочернюю категорию',
                'type'  => 'bool',
            ],
            'show_caption'   => [
                'label' => 'Показывать заголовок',
                'type'  => 'bool',
            ],
            'visible'        => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'main_items',
            'primary'   => 'id',
            'validate'  => $this->getValidatePost(),
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getAllowedRoles()
    {
        return ['admin'];
    }

    public function getDeletionRoles()
    {
        return ['admin'];
    }

    public function getModifyingRoles()
    {
        return ['admin'];
    }

    public function getInfo()
    {
        return [
            'caption' => 'Главное меню',
            'icon'    => '<i class="fa fa-th-list"></i>',
            'group'   => 'content',
        ];
    }

    public function getUnfilteredColumns()
    {
        return ['Содержание'];
    }

    public function deleteData($id = null)
    {
        DB::delete('main_items')
          ->where('id', '=', $id)
          ->execute();
        DB::delete('secondary_items')
          ->where('main_item_id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['ru_name', 'Пункт_меню'])
                  ->from('main_items')
                  ->order_by('ru_name');

        return $data->execute()
                    ->as_array();
    }

}
