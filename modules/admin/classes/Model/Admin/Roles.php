<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Roles extends Model_Admin
{
    
    public function getInsertColumns()
    {
        return [
            'tableName' => 'roles',
            'validate'  => $this->getValidatePost(),
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public function getValidatePost()
    {
        return function ($post)
        {
            if (empty($post['name']))
            {
                return 'Название роли не должно быть пустым';
            }
            if (empty($post['description']))
            {
                return 'Описание роли не должно быть пустым';
            }
            
            return true;
        };
    }
    
    public static function getCommonColumns()
    {
        return [
            'name'        => [
                'label' => 'Роль',
                'type'  => 'text',
            ],
            'description' => [
                'label' => 'Описание',
                'type'  => 'textarea',
            ],
        ];
    }
    
    public function getEditData($primary)
    {
        return [
            'tableName' => 'roles',
            'primary'   => 'id',
            'validate'  => $this->getValidatePost(),
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }
    
    public function getInfo()
    {
        return [
            'caption' => 'Роли',
            'icon'    => '<i class="fa fa-unlock"></i>',
            'group'   => 'admin',
        ];
    }
    
    public function getUnfilteredColumns()
    {
        return ['Описание'];
    }
    
    public function deleteData($id = null)
    {
        DB::delete('roles')
          ->where('id', '=', $id)
          ->execute();
    }
    
    public function getData()
    {
        
        $data = DB::select('id')
                  ->select(['name', 'Роль'])
                  ->select(['description', 'Описание'])
                  ->from('roles')
                  ->order_by('name');
        
        DB::query(Database::DELETE, 'DELETE FROM `roles_users` where role_id not in (select id from roles)')
          ->execute();
        DB::query(Database::DELETE, 'DELETE FROM `roles_users` where user_id not in (select id from users)')
          ->execute();
        
        return $data->execute()
                    ->as_array();
    }
    
}
