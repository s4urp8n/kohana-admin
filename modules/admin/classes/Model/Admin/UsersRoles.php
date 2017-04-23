<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_UsersRoles extends Model_Admin
{
    
    public function getActionButtons()
    {
        
        $buttons = parent::getActionButtons();
        
        if (isset($buttons['Удалить']))
        {
            unset($buttons['Удалить']);
        }
        
        return $buttons;
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }
    
    public function getInfo()
    {
        return [
            'caption' => '5. Роли пользователей',
            'icon'    => '<i class="fa fa-unlock"></i>',
            'group'   => 'edit',
        ];
    }
    
    public function getEditData($primary)
    {
        return [
            'tableName' => 'users',
            'update'    => function ($table, $post, $primaryColumn, $primary)
            {
                DB::delete('roles_users')
                  ->where('user_id', '=', $primary)
                  ->execute();
                if (!empty($post['roles']) && $primary != 0)
                {
                    foreach ($post['roles'] as $role_id)
                    {
                        DB::insert('roles_users')
                          ->values(
                              [
                                  'user_id' => $primary,
                                  'role_id' => $role_id,
                              ]
                          )
                          ->execute();
                    }
                }
            },
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public static function getCommonColumns()
    {
        $options = DB::select('id', 'name')
                     ->from('roles')
                     ->order_by('name')
                     ->execute()
                     ->as_array('id', 'name');
        
        return [
            'username' => [
                'label' => 'Пользователь',
                'type'  => 'caption',
            ],
            'roles[]'  => [
                'dont_select'       => true,
                'label'             => 'Роли',
                'type'              => 'multiselect',
                'options'           => $options,
                'get_current_value' => function ()
                {
                    $request = Request::initial();
                    $user_id = $request->param('primary');
                    $current_roles = DB::select('role_id')
                                       ->from('roles_users')
                                       ->where('user_id', '=', $user_id)
                                       ->execute()
                                       ->as_array('role_id', 'role_id');
                    
                    return $current_roles;
                },
            ],
        ];
    }
    
    public function getData()
    {
        
        $data = DB::select('id')
                  ->select(['username', 'Пользователь'])
                  ->select(
                      [
                          DB::expr(
                              '(select group_concat(name) from roles where id in (select role_id from roles_users where user_id=users.id))'
                          ),
                          'Роли',
                      ]
                  )
                  ->from('users')
                  ->order_by('username');
        
        return $data->execute()
                    ->as_array();
    }
    
    public function isVisible()
    {
        return false;
    }
    
}
        