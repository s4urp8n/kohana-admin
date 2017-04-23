<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_UserOrders extends Model_Admin_Orders
{

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function deleteData($id = null)
    {
        DB::delete('orders')
          ->where('id', '=', $id)
          ->execute();
    }

    public function getData()
    {

        $data = DB::select('id')
                  ->select(['cart', 'Заказ'])
                  ->select(['date', 'Дата'])
                  ->select(['time', 'Время'])
                  ->select(['completed', 'Выполнен'])
                  ->from('orders')
                  ->where(
                      'user_id', '=', Auth::instance()
                                          ->get_user()
                  )
                  ->order_by('completed', 'asc')
                  ->order_by('date', 'desc')
                  ->order_by('time', 'desc');

        return $data->execute()
                    ->as_array();
    }

    public function getInfo()
    {
        return [
            'caption' => 'Мои заказы',
            'icon'    => '<i class="fa fa-shopping-cart"></i>',
            'group'   => 'content',
        ];
    }

    public function getAllowedRoles()
    {
        return ['user'];
    }

    public function getDeletionRoles()
    {
        return ['admin'];
    }

    public function getModifyingRoles()
    {
        return ['admin'];
    }

}
