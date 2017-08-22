<?php

class Model_Articles extends ORM
{

    protected $_table_name = 'articles';

    public static function getCurrentCategory()
    {
        $request = Request::initial();

        $url = $request->url();

        if (preg_match('#/article/#i', $url) == 1) {

            $category = $request->param('id');

            $orm = ORM::factory('Articles', $category);

            if ($orm->id) {
                return $category;
            }
        }

        return false;
    }

    public static function getCurrentCategoryORM()
    {
        $category = static::getCurrentCategory();

        if ($category !== false) {
            return ORM::factory('Articles', $category);
        }

        return false;
    }

    public function getHref()
    {
        return '/' . Common::getCurrentLang() . '/article/' . \Zver\StringHelper::load($this->id . ' ' . $this->ru_name)
                                                                                ->slugify() . "?category=" . $this->id_category;
    }

}
