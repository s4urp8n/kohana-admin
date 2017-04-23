<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template
{

    public $template = 'template';

    public function action_index()
    {

        $content = '';

        $main_items = Common::getMainItemsTransliterated();

        if (!empty($main_items)) {

            $main_key = null;

            $main_item_param = $this->request->param('main_item');

            if (!empty($main_item_param)) {
                if (in_array($main_item_param, array_column($main_items, 'translit'))) {
                    foreach ($main_items as $key => $item) {
                        if ($item['translit'] == $main_item_param) {
                            $main_key = $key;
                            $main_items[$key]['active'] = true;
                            break;
                        }
                    }
                } else {
                    throw new HTTP_Exception_404();
                }
            } else {
                $main_key = array_keys($main_items)[0];
            }

            $main_items[$main_key]['active'] = true;

            $secondary_item_param = $this->request->param('secondary_item');
            $secondary_items = Common::getSecondaryItemsTransliterated($main_key);

            if (!empty($secondary_item_param)) {
                if (in_array($secondary_item_param, array_column($secondary_items, 'translit'))) {
                    foreach ($secondary_items as $key => $item) {
                        if ($item['translit'] == $secondary_item_param) {
                            $secondary_items[$key]['active'] = true;
                            $secondary_item = ORM::factory('SecondaryItem', $key);

                            $content = View::factory(
                                'parts/items_content', [
                                                         'item' => $secondary_item,
                                                     ]
                            );

                            $this->template->keywords = \Zver\StringHelper::load($secondary_item->get(Common::getCurrentLang() . '_keywords'))
                                                                          ->toHTMLEntities()
                                                                          ->get();
                            $this->template->description = \Zver\StringHelper::load($secondary_item->get(Common::getCurrentLang() . '_description'))
                                                                             ->toHTMLEntities()
                                                                             ->get();
                            $this->template->title = \Zver\StringHelper::load(
                                empty($secondary_item->get(Common::getCurrentLang() . '_title'))
                                    ? $secondary_item->get(Common::getCurrentLang() . '_name')
                                    : $secondary_item->get(Common::getCurrentLang() . '_title')
                            )
                                                                       ->toHTMLEntities()
                                                                       ->get();
                            break;
                        }
                    }
                } else {
                    throw new HTTP_Exception_404();
                }
            } else {

                $main_item = ORM::factory('MainItem', $main_key);

                if (!empty($main_item->go_child)) {

                    $childHref = Common::getSecondaryItems($main_item->id, true)
                                       ->current();
                    if (!empty($childHref->id)) {
                        $childHref = $childHref->getHref();
                    }
                    Common::redirect($childHref);
                }

                $content = View::factory(
                    'parts/items_content', [
                                             'item' => $main_item,
                                         ]
                );

                $this->template->keywords = \Zver\StringHelper::load($main_item->get(Common::getCurrentLang() . "_keywords"))
                                                              ->toHTMLEntities()
                                                              ->get();
                $this->template->description = \Zver\StringHelper::load($main_item->get(Common::getCurrentLang() . "_description"))
                                                                 ->toHTMLEntities()
                                                                 ->get();
                $this->template->title = \Zver\StringHelper::load(
                    empty($main_item->get(Common::getCurrentLang() . "_title"))
                        ? $main_item->get(Common::getCurrentLang() . "_name")
                        : $main_item->get(Common::getCurrentLang() . "_title")
                )
                                                           ->toHTMLEntities()
                                                           ->get();
            }

            $this->template->content = $content;
            $this->template->header = View::factory('parts/header', ['activeId' => $main_items[$main_key]['id']]);
            $this->template->footer = View::factory('parts/footer');
        }
    }

}
