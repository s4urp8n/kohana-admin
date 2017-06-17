<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Article extends Controller_Template
{

    public $template = 'template';

    public function action_index()
    {

        $id = $this->request->param('id');

        $article = ORM::factory('Articles', $id);

        if (empty($article->id) || (!empty($article->id) && $article->visible != 1)) {

            throw new HTTP_Exception_404();

        } else {

            $this->template->content = View::factory('modules/article-item-content', [
                'article' => $article,
            ]);

            $activeId = ORM::factory('MainItem')
                           ->where('module', '=', Modules::$MOD_ARTICLES)
                           ->find()->id;

            $this->template->header = View::factory('parts/header', ['activeId' => $activeId,]);

            $this->template->footer = View::factory('parts/footer');
        }
    }

}
