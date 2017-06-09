<?php

class Model_Articles extends ORM
{

    protected $_table_name = 'articles';

    public static function getCurrentCategory()
    {
        $request = Request::initial();

        $category = $request->query('category');

        $orm = ORM::factory('Articles', $category);

        if ($orm->id) {
            return $category;
        }

        return false;
    }

    public function getHref()
    {
        return '/' . Common::getCurrentLang() . '/article/' . \Zver\StringHelper::load($this->id . ' ' . $this->ru_name)
                                                                                ->slugify() . "?category=" . $this->id_category;
    }

}
