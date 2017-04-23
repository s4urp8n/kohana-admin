<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_UserProfile extends Model_Admin
{
    
    public function getEditData($primary)
    {
        return [
            'tableName' => 'users',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public static function getCommonColumns()
    {
        return [
            'Email'     => [
                'label' => 'email',
                'type'  => 'caption',
            ],
            'real_name' => [
                'label' => 'ФИО',
                'type'  => 'text',
            ],
            'phone'     => [
                'label' => 'Телефон',
                'type'  => 'text',
            ],
        ];
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri(
            'dataEdit', $this->getShortName(), Auth::instance()
                                                   ->get_user()
        ) . '?ref=' . urlencode(AdminHREF::getFullCurrentHREF());
    }
    
    public function getInfo()
    {
        return [
            'caption' => 'Профиль',
            'icon'    => '<i class="fa fa-user"></i>',
            'group'   => 'content',
        ];
    }
    
    public function getAllowedRoles()
    {
        $primary = Request::initial()
                          ->param('primary');
        if ($primary == Auth::instance()
                            ->get_user()
            || is_null($primary)
        )
        {
            return ['admin', 'user'];
        }
        
        return ['admin'];
    }
    
    public function getDeletionRoles()
    {
        return $this->getAllowedRoles();
    }
    
    public function getModifyingRoles()
    {
        return $this->getAllowedRoles();
    }
    
}
