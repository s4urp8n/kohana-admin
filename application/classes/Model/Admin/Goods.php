<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Goods extends Model_Admin
{

    public function getInsertColumns()
    {
        return [
            'tableName'   => 'goods',
            'uploadsDirs' => self::getUploadsParams(),
            'columns'     => self::getCommonColumns(),
            'insert'      => Common::getManyToManyInsert([
                                                             [
                                                                 'goods_categories',
                                                                 'id_good',
                                                                 'id_category',
                                                                 'shop_categories',
                                                             ],
                                                         ]),
        ];
    }

    public static function getUploadsParams($primary = null)
    {
        return [
            'Изображение' => [
                'directory'         => 'goods' . DIRECTORY_SEPARATOR . (is_null($primary)
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
            'Галерея'     => [
                'directory'         => 'goods-gallery' . DIRECTORY_SEPARATOR . (is_null($primary)
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

    /**
     * @return array
     */
    public static function getCommonColumns()
    {

        $categories = Model_ShopCategories::getListArray();

        return [
            'shop_categories[]' => Common::getManyToManyRelationArray(
                'Категории',
                $categories,
                'goods_categories',
                'id_good',
                'id_category'
            ),
            'title_ru'          => [
                'label' => 'НазваниеRU',
                'type'  => 'text',
            ],
            'title_en'          => [
                'label' => 'НазваниеEN',
                'type'  => 'text',
            ],
            'title_am'          => [
                'label' => 'НазваниеAM',
                'type'  => 'text',
            ],
            'description_ru'    => [
                'label' => 'СодержаниеRU',
                'type'  => 'editor',
            ],
            'description_en'    => [
                'label' => 'СодержаниеEN',
                'type'  => 'editor',
            ],
            'description_am'    => [
                'label' => 'СодержаниеAM',
                'type'  => 'editor',
            ],
            'price'             => [
                'label' => 'Цена',
                'type'  => 'number',
            ],
            'unit_id'           => [
                'label'   => 'Единица_измерения',
                'type'    => 'select',
                'options' => DB::select('id', 'ru_name')
                               ->from('units')
                               ->execute()
                               ->as_array('id', 'ru_name'),
            ],
            'videos'            => [
                'label' => 'Видео с youtube(вставлять ссылку)',
                'type'  => 'youtube',
            ],
            'visible'           => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName'   => 'goods',
            'primary'     => 'id',
            'uploadsDirs' => self::getUploadsParams($primary),
            'columns'     => self::getCommonColumns(),
            'update'      => Common::getManyToManyUpdate([
                                                             [
                                                                 'goods_categories',
                                                                 'id_good',
                                                                 'id_category',
                                                                 'shop_categories',
                                                             ],
                                                         ]),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Товары',
            'icon'    => '<i class="fa fa-cart-plus"></i>',
            'group'   => 'content',
        ];
    }

    public function deleteData($id = null)
    {
        parent::deleteUploads($this, $id);
        DB::delete('goods')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['title_ru', 'Название'])
                  ->from('goods')
                  ->order_by('title_ru');

        return $data->execute()
                    ->as_array();
    }

}
