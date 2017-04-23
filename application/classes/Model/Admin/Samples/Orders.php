<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Orders extends Model_Admin
{

    public function getBadge()
    {

        $count = ORM::factory('Orders')
                    ->where('completed', '=', 0)
                    ->find_all()
                    ->count();

        if ($count > 0) {
            return "<span class=\"badge\" style=\"background: red\">$count</span>";
        }

        return '';
    }

    public function getOutputFunctions()
    {
        return [
            'Заказ'        => function ($row) {
                $render = '';
                $sum = 0;
                $cart = unserialize($row['Заказ']);
                if (is_array($cart) && !empty($cart)) {
                    foreach ($cart as $good) {
                        $sum += $good['price'] * $good['count'];
                        $render .= "<div style='display:inline-block;padding: 5px;'><div><img class='previewAdminImage' src=\"/"
                                   . $good['image'] . "\"/> x " . $good['count'] . '</div>';
                        $render .= "<div> Артикул: " . ORM::factory('Articles', $good['article_id'])->article
                                   . "</div>";
                        $render .= "<div> Багет: " . $good['bag'] . "</div>";
                        $render .= "<div> Размер: " . $good['width'] . 'x' . $good['height'] . "</div></div>";
                    }
                    $render .= "<div> Сумма: " . $sum . " руб.</div>";
                }

                return $render;
            },
            'Пользователь' => function ($row) {
                $user = ORM::factory('User', $row['Пользователь']);

                return $user->username;
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

    public static function getCommonColumns()
    {
        $request = Request::initial();
        $id = $request->param('primary');
        $cart = ORM::factory('Orders', $id);

        return [
            'user_id'   => [
                'dont_select'       => true,
                'label'             => 'Пользователь',
                'type'              => 'caption',
                'get_current_value' => function () use ($cart) {
                    $user = ORM::factory('User', $cart->user_id);
                    if (!empty($user->id)) {
                        return $user->username . ' <a href="/admin/dataEdit/Users/' . $user->id . '/?ref=' . urlencode(
                                AdminHREF::getFullCurrentHREF()
                            ) . '">Просмотр пользователя</a>';
                    }

                    return 'Пользователь неопознан, его ID=' . $user->id;
                },
            ],
            'date'      => [
                'label' => 'Дата',
                'type'  => 'date',
            ],
            'time'      => [
                'label' => 'Время',
                'type'  => 'time',
            ],
            'cart'      => [
                'label'             => 'Корзина',
                'type'              => 'caption',
                'dont_select'       => true,
                'get_current_value' => function () use ($cart) {
                    $cart = unserialize($cart->cart);
                    $render = '';
                    $sum = 0;
                    if (is_array($cart) && !empty($cart)) {
                        foreach ($cart as $good) {
                            $sum += $good['price'] * $good['count'];
                            $render .= "<div style='display:inline-block;padding: 5px;'><div><img class='previewAdminImage' src=\"/"
                                       . $good['image'] . "\"/> x " . $good['count'] . '</div>';
                            $render .= "<div> Артикул: " . ORM::factory('Articles', $good['article_id'])->article
                                       . "</div>";
                            $render .= "<div> Багет: " . $good['bag'] . "</div>";
                            $render .= "<div> Размер: " . $good['width'] . 'x' . $good['height'] . "</div></div>";
                        }
                        $render .= "<div> Сумма: " . $sum . " руб.</div>";
                    }

                    return $render;
                },
            ],
            'completed' => [
                'label' => 'Выполнен',
                'type'  => 'bool',
            ],
        ];
    }

    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }

    public function getInfo()
    {
        return [
            'caption' => 'Заказы',
            'icon'    => '<i class="fa fa-shopping-cart"></i>',
            'group'   => 'content',
        ];
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
                  ->select(['completed', 'Выполнен'])
                  ->from('orders')
                  ->order_by('completed', 'asc')
                  ->order_by('date', 'desc')
                  ->order_by('time', 'desc');

        return $data->execute()
                    ->as_array();
    }

    public function getDeletionRoles()
    {
        return $this->getAllowedRoles();
    }

    public function getAllowedRoles()
    {
        return ['admin'];
    }

    public function getModifyingRoles()
    {
        return $this->getAllowedRoles();
    }

}
