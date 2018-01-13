<?php

namespace App;

class News extends \Illuminate\Database\Eloquent\Model
{
    protected static $unguarded = true;
    protected $table = 'news';
    public $timestamps = false;
}
