<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Bags extends Model_Admin
{

    public function getUploadsClass()
    {
        return 'inlineBlock';
    }

    public function getOutputFunctions()
    {
        return [
            'Изображения' => function ($row) {

                $model = new self();
                $uploadsKeys = $this->getUploadsParams();
                $uploadsKeys = array_keys($uploadsKeys);
                $uploads = [];

                foreach ($uploadsKeys as $key) {
                    $uploads = array_merge($uploads, $model->getSharedModelUploads($model, $row['id'], $key));
                }

                //only images
                foreach ($uploads as $key => $upload) {
                    if (Admin::isImageFile($upload)) {
                        ?>
                        <img src="<?= $upload ?>"/>
                        <?php
                    }
                }

            },
        ];
    }

    public static function getUploadsParams($primary = null)
    {
        return [
            'Заполнение' => [
                'directory'         => __CLASS__ . 'Fill' . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
                'allowedExtensions' => [
                    'png',
                ],
            ],
            'Уголок'     => [
                'directory'         => __CLASS__ . 'Corner' . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
                'allowedExtensions' => [
                    'png',
                ],
            ],
            'Срез'       => [
                'directory'         => __CLASS__ . 'Projection' . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
                'allowedExtensions' => [
                    'png',
                ],
            ],
        ];
    }

    public function getUnfilteredColumns()
    {
        return [
            'Изображения',
        ];
    }

    public function getUploadsText()
    {
        return '<strong>Заполнение</strong> - это повторяющийся участок багета, в данном случае верхняя его часть.<br/>
                <strong>Уголок</strong> - это левый верхний угол багета.<br/>
                Картинки нужно загружать сохраняя пропорции: <strong>1 см багета = 10 пикселей</strong> на картинке.<br/>
                То есть заполнение багета шириной 2 см должно быть 20 пикселей в высоту и необходимой для повторения ширины, а уголок должен быть 40х40 пикселей
                с прозрачным фоном.';
    }

    public function getInsertColumns()
    {
        return [
            'tableName'   => 'bags',
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams(),
        ];
    }

    public function getValidatePost()
    {
        return function ($post) {
            if (empty($post['number'])) {
                return 'Название не должно быть пустым';
            }

            return true;
        };
    }

    public static function getCommonColumns()
    {
        return [
            'number'  => [
                'label' => 'Номер',
                'type'  => 'text',
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
            'uploadsDirs' => self::getUploadsParams($primary),
            'tableName'   => 'bags',
            'primary'     => 'id',
            'validate'    => $this->getValidatePost(),
            'columns'     => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Багеты',
            'icon'    => '<i class="fa fa-object-ungroup"></i>',
            'group'   => 'dicts',
        ];
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('bags')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['number', 'Номер'])
                  ->select(['id', 'Изображения'])
                  ->select(
                      [
                          'visible',
                          'Видимость',
                      ]
                  )
                  ->from('bags')
                  ->order_by('number');

        return $data->execute()
                    ->as_array();
    }

}
