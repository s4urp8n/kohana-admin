<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Template
{

    public $template = 'template';

    public function action_index()
    {

        $id = $this->request->param('id');

        $new = ORM::factory('News', $id);

        if (empty($new->id) || (!empty($new->id) && $new->visible != 1)) {
            throw new HTTP_Exception_404();
        } else {

            $previous = $next = null;

            $news = Common::getNews();

            foreach ($news as $index => $newItem) {
                if ($newItem->id == $id) {

                    if (isset($news[$index + 1])) {
                        $next = $news[$index + 1];
                    }

                    if (isset($news[$index - 1])) {
                        $previous = $news[$index - 1];
                    }

                    break;
                }
            }

            $activeId = ORM::factory('MainItem')
                           ->where('module', '=', Modules::$MOD_NEWS)
                           ->find()->id;

            $this->template->content = View::factory('parts/news/news_content', [
                'new'      => $new,
                'next'     => $next,
                'previous' => $previous,
            ]);

            $this->template->header = View::factory('parts/header', [
                'activeId' => $activeId,
            ]);

            $this->template->footer = View::factory('parts/footer');
        }
    }

}
