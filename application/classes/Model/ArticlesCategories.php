<?php

class Model_ArticlesCategories extends ORM
{

    protected $_table_name = 'articles_categories';

    public function getHref()
    {
        return Common::getArticlesMainItem()
                     ->getHref() . "?category=" . \Zver\StringHelper::load($this->en_name)
                                                                    ->slugify();
    }

}
