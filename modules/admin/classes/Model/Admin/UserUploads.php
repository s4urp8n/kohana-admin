<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_UserUploads extends Model_Admin_Uploads
{
    
    public function getInfo()
    {
        return [
            'caption' => 'Файлы для загрузки',
            'icon'    => '<i class="fa fa-image"></i>',
            'group'   => 'upload',
        ];
    }
    
    public function getUploadDir()
    {
        return [
            'Файлы для загрузки' => [
                'directory' => 'user_uploads' . DIRECTORY_SEPARATOR,
            ],
        ];
    }
    
}
