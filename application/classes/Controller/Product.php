<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Product extends Controller_Template
{

    public $template = 'template';

    public function action_index()
    {

        $id = $this->request->param('id');

        $product = ORM::factory('Goods', $id);

        if (empty($product->id) || (!empty($product->id) && $product->visible != 1)) {

            throw new HTTP_Exception_404();

        } else {

            $this->template->content = View::factory('modules/shop-item-content', [
                'product' => $product,
            ]);

            $activeId = ORM::factory('MainItem')
                           ->where('module', '=', Modules::$MOD_SHOP)
                           ->find()->id;

            $this->template->header = View::factory('parts/header', ['activeId' => $activeId,]);

            $this->template->footer = View::factory('parts/footer');
        }
    }

}
