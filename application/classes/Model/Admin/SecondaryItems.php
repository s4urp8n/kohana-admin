<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_SecondaryItems extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName' => 'secondary_items',
            'columns'   => self::getCommonColumns(),
            'validate'  => $this->getValidatePost(),
        ];
    }

    public static function getCommonColumns()
    {
        $options = DB::select('id', 'ru_name')
                     ->from('main_items')
                     ->order_by('ru_name')
                     ->execute()
                     ->as_array('id', 'ru_name');

        return [
            'main_item_id'   => [
                'label'   => 'Категория',
                'type'    => 'select',
                'options' => $options,
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
            'module'         => [
                'label'   => 'Модуль',
                'type'    => 'select',
                'options' => Modules::getModulesKeys(),
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

    public function getValidatePost()
    {
        return function ($post) {
            if (empty($post['ru_name']) || empty($post['en_name'])) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public function getEditData($primary)
    {
        return [
            'validate'  => $this->getValidatePost(),
            'tableName' => 'secondary_items',
            'primary'   => 'id',
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
            'caption' => 'Главное меню (подкатегории)',
            'icon'    => '<i class="fa fa-list-alt"></i>',
            'group'   => 'content',
        ];
    }

    public function getUnfilteredColumns()
    {
        return ['Содержание'];
    }

    public function deleteData($id = null)
    {
        DB::delete('secondary_items')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('secondary_items.id')
                  ->select(
                      [
                          'main_items.ru_name',
                          'Категория',
                      ]
                  )
                  ->select(['secondary_items.ru_name', 'Подкатегория'])
                  ->from('secondary_items')
                  ->join('main_items', 'left')
                  ->on('main_items.id', '=', 'secondary_items.main_item_id')
                  ->order_by('main_items.ru_name')
                  ->order_by('secondary_items.ru_name');

        return $data->execute()
                    ->as_array();
    }

}
