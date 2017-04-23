<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_UsersPasswords extends Model_Admin
{
    
    public function getInsertColumns()
    {
        return [
            'tableName' => 'users',
            'validate'  => $this->getValidatePost(),
            'insert'    => function ($table, $post)
            {
                $post['password'] = Auth::instance()
                                        ->hash($post['password']);
                
                return DB::insert($table, array_keys($post))
                         ->values(array_values($post))
                         ->execute();
            },
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public function getValidatePost()
    {
        return function ($post)
        {
            if (empty($post['password']))
            {
                return 'Пароль не должен быть пустым';
            }
            
            return true;
        };
    }
    
    public static function getCommonColumns()
    {
        return [
            'username' => [
                'label' => 'Пользователь',
                'type'  => 'caption',
            ],
            'password' => [
                'label' => 'Пароль',
                'type'  => 'password',
            ],
        ];
    }
    
    public function getEditData($primary)
    {
        return [
            'tableName' => 'users',
            'primary'   => 'id',
            'validate'  => $this->getValidatePost(),
            'update'    => function ($table, $post, $primaryColumn, $primary)
            {
                $post['password'] = Auth::instance()
                                        ->hash($post['password']);
                DB::update($table)
                  ->set($post)
                  ->where($primaryColumn, '=', $primary)
                  ->execute();
            },
            'columns'   => self::getCommonColumns(),
        ];
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }
    
    public function getActionButtons()
    {
        
        $buttons = parent::getActionButtons();
        
        if (isset($buttons['Удалить']))
        {
            unset($buttons['Удалить']);
        }
        
        return $buttons;
    }
    
    public function getInfo()
    {
        return [
            'caption' => '5. Смена паролей',
            'icon'    => '<i class="fa fa-users"></i>',
            'group'   => 'edit',
        ];
    }
    
    public function getData()
    {
        
        $data = DB::select('id')
                  ->select(['username', 'Пользователь'])
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
