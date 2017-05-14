<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_MainItems extends Model_Admin
{

    protected static $tableName = 'main_items';

    public function getInsertColumns()
    {
        return [
            'tableName'   => static::$tableName,
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams(),
        ];
    }

    public static function getUploadsParams($primary = null)
    {
        return [
            'Галерея' => [
                'directory'         => __CLASS__ . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 100 * 1024 * 1024,
                'allowedExtensions' => [
                    'jpg',
                    'jpeg',
                    'bmp',
                    'png',
                ],
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
            'videos'         => [
                'label' => 'Видео с youtube(вставлять ссылку)',
                'type'  => 'youtube',
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
            'tableName'   => static::$tableName,
            'primary'     => 'id',
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams($primary),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Главное меню',
            'icon'    => '<i class="fa fa-th-list"></i>',
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
                  ->select(['ru_name', 'Пункт_меню'])
                  ->from('main_items')
                  ->order_by('ru_name');

        return $data->execute()
                    ->as_array();
    }

}
