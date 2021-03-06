<?php

class Model_ArticlesCategories extends ORM
{

    protected $_table_name = 'articles_categories';

    public static function getCurrentCategory()
    {
        $request = Request::initial();

        $url = $request->url();

        if (preg_match('#/home#i', $url) == 1) {

            $category = $request->query('category');

            $orm = ORM::factory('ArticlesCategories', $category);

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
            return ORM::factory('ArticlesCategories', $category);
        }

        return false;
    }

    public function getHref()
    {
        return Common::getArticlesMainItem()
                     ->getHref() . "?category=" . \Zver\StringHelper::load($this->id)
                                                                    ->slugify();
    }

}
