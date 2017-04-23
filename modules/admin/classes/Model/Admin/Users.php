<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Users extends Model_Admin
{
    
    public function getInsertColumns()
    {
        return [
            'tableName'   => 'users',
            'validate'    => $this->getValidateInsert(),
            'insert'      => function ($table, $post)
            {
                $post['password'] = Auth::instance()
                                        ->hash($post['password']);
                
                return DB::insert($table, array_keys($post))
                         ->values(array_values($post))
                         ->execute();
            },
            'columns'     => self::getCommonColumns(),
            'uploadsDirs' => self::getUploadsParams(),
        ];
    }
    
    public function getValidateInsert()
    {
        return function ($post)
        {
            if (empty($post['password']))
            {
                return 'Пароль не должен быть пустым';
            }
            if (empty($post['username']))
            {
                return 'Имя пользователя не должно быть пустым';
            }
            
            return true;
        };
    }
    
    public static function getCommonColumns()
    {
        return [
            'username'    => [
                'label' => 'Пользователь',
                'type'  => 'text',
            ],
            'password'    => [
                'label' => 'Пароль',
                'type'  => 'password',
            ],
            'phone'       => [
                'label' => 'Телефон',
                'type'  => 'text',
            ],
            'email'       => [
                'label' => 'email',
                'type'  => 'email',
            ],
            'real_name'   => [
                'label' => 'Реальное_имя',
                'type'  => 'text',
            ],
            'description' => [
                'label' => 'Дополнительная_информация',
                'type'  => 'textarea',
            ],
        ];
    }
    
    public static function getUploadsParams($primary = null)
    {
        return [
            'Аватар' => [
                'directory'         => __CLASS__ . DIRECTORY_SEPARATOR . (is_null($primary)
                        ? '<primary>'
                        : $primary) . DIRECTORY_SEPARATOR,
                'uploadMaxSize'     => 10 * 1024 * 1024,
                'allowedExtensions' => [
                    'jpg',
                    'jpeg',
                    'bmp',
                    'png',
                ],
            ],
        ];
    }
    
    public function getEditData($primary)
    {
        $columns = self::getCommonColumns();
        
        unset($columns['password']);
        
        return [
            'tableName'   => 'users',
            'uploadsDirs' => self::getUploadsParams($primary),
            'primary'     => 'id',
            'validate'    => $this->getValidateEdit(),
            'columns'     => $columns,
        ];
    }
    
    public function getValidateEdit()
    {
        return function ($post)
        {
            if (empty($post['username']))
            {
                return 'Имя пользователя не должно быть пустым';
            }
            
            return true;
        };
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }
    
    public function getActionButtons()
    {
        
        $buttons = parent::getActionButtons();
        
        $ref = urlencode(AdminHREF::getFullCurrentHREF());
        
        $changePass = function ($row) use ($ref)
        {
            $href = AdminHREF::getDefaultAdminRouteUri('dataEdit', 'UsersPasswords', $row['id']) . '/?ref=' . $ref;
            $text = '<i class="fa fa-lock gc"></i>';
            
            return '<a title="Сменить пароль"  href="' . $href . '">' . $text . '</a>';
        };
        
        $changeRoles = function ($row) use ($ref)
        {
            $href = AdminHREF::getDefaultAdminRouteUri('dataEdit', 'UsersRoles', $row['id']) . '/?ref=' . $ref;
            $text = '<i class="fa fa-user-secret gc"></i>';
            
            return '<a title="Роли пользователя" href="' . $href . '">' . $text . '</a>';
        };
        
        $loginUser = function ($row) use ($ref)
        {
            $href = AdminHREF::getDefaultAdminRouteUri('loginuser', 'users', $row['id']);
            $text = '<i class="fa fa-sign-in gc"></i>';
            
            return '<a title="Войти от имени пользователя" href="' . $href . '">' . $text . '</a>';
        };
        
        $buttons['Роли пользователя'] = $changeRoles;
        $buttons['Сменить пароль'] = $changePass;
        $buttons['Войти'] = $loginUser;
        
        return $buttons;
    }
    
    public function getInfo()
    {
        return [
            'caption' => 'Пользователи',
            'icon'    => '<i class="fa fa-users"></i>',
            'group'   => 'admin',
        ];
    }
    
    public function getUnfilteredColumns()
    {
        return ['Дополнительная_информация', 'Роли'];
    }
    
    public function deleteData($id = null)
    {
        DB::delete('users')
          ->where('id', '=', $id)
          ->execute();
        DB::delete('roles_users')
          ->where('user_id', '=', $id)
          ->execute();
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
                  ->select(['description', 'Дополнительная_информация'])
                  ->select('email')
                  ->from('users')
                  ->order_by('username');
        
        return $data->execute()
                    ->as_array();
    }
    
}
