<?php

namespace App;

use Zver\StringHelper;

class Products extends \Illuminate\Database\Eloquent\Model
{
    protected static $unguarded = true;
    protected $table = 'products';
    public $timestamps = false;

    public function getCategory()
    {
        return ProductsCategories::find($this->id_category);
    }

    public function getSlug()
    {
        return StringHelper::load($this->name)
                           ->slugify()
                           ->get();
    }

    public function getHref()
    {
        return '/product/' . $this->id . '-' . $this->getSlug();
    }
}
