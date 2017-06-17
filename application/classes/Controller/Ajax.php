<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller
{

    public function action_remove()
    {
        $id = $this->request->query('id');
        $ref = $this->request->query('ref');
        if (empty($id) || empty($ref)) {
            throw new HTTP_Exception_404();
        }

        Cart::remove($id);

        HTTP::redirect($ref);
    }

    public function action_inc()
    {
        $id = $this->request->query('id');
        $ref = $this->request->query('ref');
        if (empty($id) || empty($ref)) {
            throw new HTTP_Exception_404();
        }

        if (Cart::in($id)) {
            $cart = Cart::get();
            if (is_numeric($cart[$id]['count'])) {
                ++$cart[$id]['count'];
            } else {
                $cart[$id]['count'] = 1;
            }
            Cart::set($cart);
        }

        HTTP::redirect($ref);
    }

    public function action_dec()
    {
        $id = $this->request->query('id');
        $ref = $this->request->query('ref');
        if (empty($id) || empty($ref)) {
            throw new HTTP_Exception_404();
        }

        if (Cart::in($id)) {
            $cart = Cart::get();
            if (is_numeric($cart[$id]['count']) && $cart[$id]['count'] != 1) {
                --$cart[$id]['count'];
            } else {
                $cart[$id]['count'] = 1;
            }
            Cart::set($cart);
        }

        HTTP::redirect($ref);
    }

    public function action_changePass()
    {

        $result = 'error=1';

        $ref = filter_input(INPUT_POST, 'ref', FILTER_SANITIZE_STRING);

        if (Auth::instance()
                ->logged_in('user')
        ) {

            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if (!empty($password) && \Zver\StringHelper::load($password)
                                                       ->getLength() > 5
            ) {

                $user = Auth::instance()
                            ->get_user();

                $user->password = $password;

                $user->save();

                $result = 'success=1';

            }

        }

        if (\Zver\StringHelper::load($ref)
                              ->isContain('?')
        ) {
            $ref .= '&' . $result;
        } else {
            $ref .= '?' . $result;
        }

        Common::redirect($ref);

    }

    public function action_buy()
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $count = filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);
        $ref = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_STRING);

        if (
            empty($ref)
            ||
            empty($count)
            ||
            empty($id)
        ) {
            throw new HTTP_Exception_404();
        }

        $identity = Modules::getCartIdentity($id);

        $good = ORM::factory('Goods', $id);

        if (empty($good->id)) {
            throw new HTTP_Exception_404();
        }

        Cart::add($identity, [
            'count' => $count,
            'id'    => $id,
            'price' => $good->price,
        ]);

        HTTP::redirect($ref);

    }

}
