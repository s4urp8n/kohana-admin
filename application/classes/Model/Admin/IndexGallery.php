<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_IndexGallery extends Model_Admin
{
    public static function getUploadsParams($primary = null)
    {
        return [
            'Картинка1020x300' => [
                'directory'         => __CLASS__ . DIRECTORY_SEPARATOR . (is_null($primary) ? '<primary>' : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
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
            if (empty($post['ru_caption']) || empty($post['en_caption'])) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public static function getCommonColumns()
    {
        return [
            'ru_caption' => [
                'label' => 'ЗаголовокRU',
                'type'  => 'text',
            ],
            'en_caption' => [
                'label' => 'ЗаголовокEN',
                'type'  => 'text',
            ],
            'am_caption' => [
                'label' => 'ЗаголовокAM',
                'type'  => 'text',
            ],
            'link'       => [
                'label' => 'Ссылка',
                'type'  => 'text',
            ],
            'visible'    => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getInsertColumns()
    {
        return [
            'tableName'   => 'index_gallery',
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams(),
        ];
    }

    public function getEditData($primary)
    {
        return [
            'uploadsDirs' => self::getUploadsParams($primary),
            'tableName'   => 'index_gallery',
            'primary'     => 'id',
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('index_gallery')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {
        $data = DB::select('id')
                  ->select(['ru_caption', 'Заголовок',])
                  ->from('index_gallery')
                  ->order_by('ru_caption');

        return $data->execute()
                    ->as_array();
    }

    public function getInfo()
    {
        return [
            'caption' => 'Карусель на главной',
            'icon'    => '<i class="fa fa-th-list"></i>',
            'group'   => 'content',
        ];
    }
}
