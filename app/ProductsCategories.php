<?php

namespace App;

use Zver\StringHelper;

class ProductsCategories extends \Illuminate\Database\Eloquent\Model
{
    protected static $unguarded = true;
    public $timestamps = false;
    protected $table = 'products_categories';

    public static function getCategories()
    {
        return static::orderBy('category')
                     ->get();
    }

    public function getSlug()
    {
        return StringHelper::load($this->category)
                           ->slugify()
                           ->get();
    }

    public function getHref()
    {
        return '/catalog/' . $this->getSlug();
    }

}
