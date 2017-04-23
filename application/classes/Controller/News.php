<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Template
{

    public $template = 'template';

    public function action_index()
    {

        $id = $this->request->param('id');

        $new = ORM::factory('News', $id);

        if (empty($new->id)) {
            throw new HTTP_Exception_404();
        } else {
            $this->template->content = View::factory(
                'parts/news/news_content', [
                                             'new' => $new,
                                         ]
            );

            $activeId = ORM::factory('MainItem')
                           ->where('module', '=', Modules::$MOD_NEWS)
                           ->find()->id;

            $this->template->header = View::factory(
                'parts/header', [
                                  'activeId' => $activeId,
                              ]
            );
            $this->template->footer = View::factory('parts/footer');
        }
    }

}
