<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Articles extends Model_Admin
{

    public function getUploadsClass()
    {
        return 'inlineBlock';
    }

    public function getOutputFunctions()
    {
        return [
            'Изображение' => function ($row) {

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
                        <img src="<?= ImagePreview::getPreview($upload, 100, 100) ?>"/>
                        <?php
                    }
                    break;
                }

            },
        ];
    }

    public static function getUploadsParams($primary = null)
    {
        $sizes = ORM::factory('Sizes')
                    ->where('visible', '=', 1)
                    ->find_all();

        $result = [];

        foreach ($sizes as $size) {
            $result[$size->width . 'x' . $size->height] = [
                'directory'         => __CLASS__ . DIRECTORY_SEPARATOR . ($size->width . 'x' . $size->height)
                                       . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
                'allowedExtensions' => ['jpeg', 'jpg', 'png'],
            ];
        }

        return $result;
    }

    public function getUnfilteredColumns()
    {
        return [
            'Изображение',
        ];
    }

    public function getUploadsText()
    {
        return 'Загружать картинки нужно соблюдая пропорции!<br/>
        Например: картину размером 45х30см надо грузить 450х300 пикселей.';
    }

    public function getInsertColumns()
    {
        return [
            'tableName'   => 'articles',
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams(),
            'insert'      => Common::getManyToManyInsert(
                [
                    ['articles_types', 'id_article', 'id_type', 'types'],
                    [
                        'articles_categories',
                        'id_article',
                        'id_category',
                        'categories',
                    ],
                    [
                        'articles_bags',
                        'id_article',
                        'id_bag',
                        'bags',
                    ],
                ]
            ),
        ];
    }

    public static function getCommonColumns()
    {

        $bagsPickerImages = [
            'getImage' => function ($id) {
                $bag = ORM::factory('Bags', $id);
                $image = $bag->getPicture(true);

                return ['data-img-src' => $image];
            },
        ];

        return [
            'article'      => [
                'label' => 'Артикул',
                'type'  => 'text',
            ],
            'visible'      => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
            'types[]'      => Common::getManyToManyRelationArray(
                'Тип', DB::select('id', 'name')
                         ->from('types')
                         ->where('visible', '=', 1)
                         ->order_by('name')
                         ->execute()
                         ->as_array('id', 'name'), 'articles_types', 'id_article', 'id_type'
            ),
            'categories[]' => Common::getManyToManyRelationArray(
                'Категории', DB::select('id', 'name')
                               ->from('secondary_items')
                               ->where('visible', '=', 1)
                               ->order_by('name')
                               ->execute()
                               ->as_array('id', 'name'), 'articles_categories', 'id_article', 'id_category'
            ),
            'bags[]'       => Common::getManyToManyRelationArray(
                'Багеты', DB::select('id', 'number')
                            ->from('bags')
                            ->where('visible', '=', 1)
                            ->order_by('number')
                            ->execute()
                            ->as_array('id', 'number'), 'articles_bags', 'id_article', 'id_bag', 'imagepicker',
                $bagsPickerImages
            ),
        ];
    }

    public function getEditData($primary)
    {
        return [
            'uploadsDirs' => self::getUploadsParams($primary),
            'tableName'   => 'articles',
            'primary'     => 'id',
            'columns'     => self::getCommonColumns(),
            'update'      => Common::getManyToManyUpdate(
                [
                    ['articles_types', 'id_article', 'id_type', 'types'],
                    [
                        'articles_categories',
                        'id_article',
                        'id_category',
                        'categories',
                    ],
                    [
                        'articles_bags',
                        'id_article',
                        'id_bag',
                        'bags',
                    ],
                ]
            ),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Артикулы',
            'icon'    => '<i class="fa fa-picture-o"></i>',
            'group'   => 'dicts',
        ];
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('articles')
          ->where('id', '=', $id)
          ->execute();
        DB::delete('articles_bags')
          ->where('id_article', '=', $id)
          ->execute();
        DB::delete('articles_categories')
          ->where('id_article', '=', $id)
          ->execute();
        DB::delete('articles_types')
          ->where('id_article', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $categoriesSelect = '(select GROUP_CONCAT(name ORDER BY name SEPARATOR ", " ) from secondary_items where id in
            (select
              id_category
            from
              articles_categories
            where
              articles_categories.id_article=articles.id)
        )';

        $data = DB::select('id')
                  ->select(['id', 'Изображение'])
                  ->select(['article', 'Номер'])
                  ->select([DB::expr($categoriesSelect), 'Категория'])
                  ->select(['visible', 'Видимость'])
                  ->from('articles')
                  ->order_by('article');

        return $data->execute()
                    ->as_array();
    }

}
