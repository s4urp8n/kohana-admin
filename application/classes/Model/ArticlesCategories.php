<?php

class Model_ArticlesCategories extends ORM
{

    protected $_table_name = 'articles_categories';

    public static function getCurrentCategory()
    {
        $request = Request::initial();

        $category = $request->query('category');

        $orm = ORM::factory('ArticlesCategories', $category);

        if ($orm->id) {
            return $category;
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
