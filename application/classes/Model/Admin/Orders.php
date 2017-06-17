<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Orders extends Model_Admin
{

    public static function getCommonColumns()
    {
        $request = Request::initial();
        $id = $request->param('primary');
        $cart = ORM::factory('Orders', $id);

        return [
            'user_id' => [
                'dont_select'       => true,
                'label'             => 'Пользователь',
                'type'              => 'caption',
                'get_current_value' => function () use ($cart) {
                    $user = ORM::factory('User', $cart->user_id);
                    if (!empty($user->id)) {
                        return $user->username . ' <a href="/admin/dataEdit/Users/' . $user->id . '/?ref=' . urlencode(AdminHREF::getFullCurrentHREF()) . '">Просмотр пользователя</a>';
                    }

                    return 'Пользователь неопознан, его ID=' . $user->id;
                },
            ],
            'date'    => [
                'label' => 'Дата',
                'type'  => 'date',
            ],
            'time'    => [
                'label' => 'Время',
                'type'  => 'time',
            ],
            'cart'    => [
                'label'             => 'Корзина',
                'type'              => 'caption',
                'dont_select'       => true,
                'get_current_value' => function () use ($cart) {

                    $cart = json_decode($cart->cart, true);

                    return View::factory('modules/cartTable', [
                        'cart'       => $cart,
                        'noInteract' => 1,
                    ]);
                },
            ],
            'status'  => [
                'label'   => 'Статус',
                'type'    => 'select',
                'options' => Common::getOrderStatuses(),
            ],
        ];
    }

    public function getOutputFunctions()
    {
        return [
            'Заказ'        => function ($row) {

                $cart = json_decode($row['Заказ'], true);

                return View::factory('modules/cartTable', [
                    'cart'       => $cart,
                    'noInteract' => 1,
                ]);
            },
            'Пользователь' => function ($row) {
                $user = ORM::factory('User', $row['Пользователь']);

                return $user->username;
            },
            'Статус'       => function ($row) {
                return Common::getOrderStatuses()[$row['Статус']];
            },
        ];
    }

    public function getEditData($primary)
    {
        return [
            'tableName' => 'orders',
            'primary'   => 'id',
            'columns'   => self::getCommonColumns(),
        ];
    }

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
                  ->select(['user_id', 'Пользователь'])
                  ->select(['cart', 'Заказ'])
                  ->select(['date', 'Дата'])
                  ->select(['time', 'Время'])
                  ->select(['status', 'Статус'])
                  ->from('orders')
                  ->order_by('status', 'asc')
                  ->order_by('date', 'desc')
                  ->order_by('time', 'desc');

        return $data->execute()
                    ->as_array();
    }

    public function getInfo()
    {
        return [
            'caption' => 'Заказы',
            'icon'    => '<i class="fa fa-shopping-cart"></i>',
            'group'   => 'content',
        ];
    }

}
