<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_News extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName'   => 'news',
            'uploadsDirs' => self::getUploadsParams(),
            'columns'     => self::getCommonColumns(),
        ];
    }

    public static function getUploadsParams($primary = null)
    {
        return [
            'Изображение' => [
                'directory'         => 'news' . DIRECTORY_SEPARATOR . (is_null($primary)
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

    public static function getCommonColumns()
    {
        return [
            'ru_caption'     => [
                'label' => 'НазваниеRU',
                'type'  => 'text',
            ],
            'en_caption'     => [
                'label' => 'НазваниеEN',
                'type'  => 'text',
            ],
            'ru_text'        => [
                'label' => 'СодержаниеRU',
                'type'  => 'editor',
            ],
            'en_text'        => [
                'label' => 'СодержаниеEN',
                'type'  => 'editor',
            ],
            '_datetime'      => [
                'label' => 'Дата',
                'type'  => 'date',
            ],
            'videos'         => [
                'label' => 'Видео с youtube(вставлять ссылку)',
                'type'  => 'youtube',
            ],
            'ru_title'       => [
                'label' => 'titleRU',
                'type'  => 'text',
            ],
            'en_title'       => [
                'label' => 'titleEN',
                'type'  => 'text',
            ],
            'ru_description' => [
                'label' => 'descriptionRU',
                'type'  => 'textarea',
            ],
            'en_description' => [
                'label' => 'descriptionEN',
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
            'visible'        => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName'   => 'news',
            'primary'     => 'id',
            'uploadsDirs' => self::getUploadsParams($primary),
            'columns'     => self::getCommonColumns(),
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
            'caption' => 'Новости',
            'icon'    => '<i class="fa fa-pencil-square-o"></i>',
            'group'   => 'content',
        ];
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('news')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['ru_caption', 'Название'])
                  ->select(
                      [
                          '_datetime',
                          'Дата',
                      ]
                  )
                  ->from('news')
                  ->order_by('_datetime', 'desc')
                  ->order_by('ru_caption');

        return $data->execute()
                    ->as_array();
    }

}
