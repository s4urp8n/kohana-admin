<?php

class Upload
{
    
    public static function getDescription($file)
    {
        $info = self::getUploadInfo($file);
        if ($info && !empty($info->description))
        {
            return $info->description;
        }
        
        return '';
    }
    
    public static function getUploadInfo($file)
    {
        $name = md5($file);
        $info = ORM::factory('Uploads')
                   ->where('name', '=', $name)
                   ->find();
        if (!empty($info->id))
        {
            return $info;
        }
        
        return false;
    }
    
    public static function setDescription($file, $description)
    {
        $info = self::getUploadInfo($file);
        if (!$info)
        {
            $info = new Model_Uploads();
            $info->name = md5($file);
        }
        $info->description = $description;
        $info->save();
    }
    
}
