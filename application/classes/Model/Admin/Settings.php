<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Settings extends Model_Admin
{
    public static function getCommonColumns()
    {
        return [
            'contact_email'     => [
                'label' => 'Контактный_EMAIL',
                'type'  => 'email',
            ],
            'contact_phone'     => [
                'label' => 'Контактный_Телефон',
                'type'  => 'text',
            ],
            'contact_latitude'  => [
                'label' => 'Широта',
                'type'  => 'text',
            ],
            'contact_longitude' => [
                'label' => 'Долгота',
                'type'  => 'text',
            ],
        ];
    }

    public function getInsertColumns()
    {
        return [
            'tableName' => 'settings',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'settings',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('dataEdit', $this->getShortName(), 1) . '?ref='
               . urlencode(AdminHREF::getFullCurrentHREF());
    }

    public function getAllowedRoles()
    {
        return ['admin'];
    }

    public function getDeletionRoles()
    {
        return ['admin'];
    }

    public function getModifyingRoles()
    {
        return ['admin'];
    }

    public function deleteData($id = null)
    {
        DB::delete('settings')
          ->where('id', '=', $id)
          ->execute();
    }

    public function isDeletionAllowed()
    {
        return [];
    }

    public function getData()
    {
        $data = DB::select('id')
                  ->from('settings');

        foreach ($this->getCommonColumns() as $name => $column) {
            $data->select([
                              $name,
                              $column['label'],
                          ]);
        }

        return $data->execute()
                    ->as_array();
    }

    public function getInfo()
    {
        return [
            'caption' => 'Настройки',
            'icon'    => '<i class="fa fa-gears"></i>',
            'group'   => 'admin',
        ];
    }

    public static function get($key)
    {
        return ORM::factory('Settings', 1)
                  ->get($key);
    }
}
