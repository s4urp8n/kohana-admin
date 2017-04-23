<?php

class Settings
{
    public static function get($key)
    {
        return ORM::factory('Settings')
                  ->find(1)
                  ->get($key);
    }
}