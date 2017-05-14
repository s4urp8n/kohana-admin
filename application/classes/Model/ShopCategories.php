<?php

class Model_ShopCategories extends ORM
{

    protected $_table_name = 'shop_categories';

    public static function getList($onlyVisible = false)
    {
        $relations = [];

        $select = DB::select()
                    ->from('shop_categories');

        if ($onlyVisible) {
            $select = $select->where('visible', '=', 1);
        }

        foreach ($select->execute()
                        ->as_array() as $item) {
            $relations[] = [
                'id'     => $item['id'],
                'parent' => $item['id_parent'],
                'data'   => $item,
            ];
        }

        return \Zver\AdjacencyList::load($relations);
    }

    public function getHref()
    {
        return Common::getShopMainItem()
                     ->getHref() . "?category=" . \Zver\StringHelper::load($this->en_name)
                                                                    ->slugify();
    }

}
