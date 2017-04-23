<?php

class Common
{

    public static function redirect($url)
    {
        header('Location:' . $url);
        die();
    }

    public static function getManyToManyInsert($arguments)
    {

        $through_table = $own_id = $foreign_id = $post_name = [];

        if (is_array($arguments)) {
            foreach ($arguments as $arg) {
                $through_table[] = $arg[0];
                $own_id[] = $arg[1];
                $foreign_id[] = $arg[2];
                $post_name[] = $arg[3];
            }
        } elseif (func_num_args() == 4) {
            $through_table = [func_get_arg(0)];
            $own_id = [func_get_arg(1)];
            $foreign_id = [func_get_arg(2)];
            $post_name = [func_get_arg(3)];
        }

        return function ($table, $post) use (
            $through_table,
            $own_id,
            $foreign_id,
            $post_name
        ) {

            $unsetPost = $post;

            foreach ($post_name as $post_name_unset) {
                if (!empty($unsetPost[$post_name_unset])) {
                    unset($unsetPost[$post_name_unset]);
                }
            }

            /**
             * Regular insert first
             */
            $insert = DB::insert($table, array_keys($unsetPost))
                        ->values(array_values($unsetPost))
                        ->execute();

            /**
             * Many-to-many insert
             */
            foreach ($through_table as $index => $ttable) {
                if (!empty($post[$post_name[$index]]) && $insert[0] != 0) {
                    foreach ($post[$post_name[$index]] as $id) {
                        DB::insert($ttable)
                          ->values(
                              [
                                  $own_id[$index]     => $insert[0],
                                  $foreign_id[$index] => $id,
                              ]
                          )
                          ->execute();
                    }
                }
            }

            return $insert;
        };
    }

    public static function getManyToManyUpdate($arguments)
    {

        $through_table = $own_id = $foreign_id = $post_name = [];

        if (is_array($arguments)) {
            foreach ($arguments as $arg) {
                $through_table[] = $arg[0];
                $own_id[] = $arg[1];
                $foreign_id[] = $arg[2];
                $post_name[] = $arg[3];
            }
        } elseif (func_num_args() == 4) {
            $through_table = [func_get_arg(0)];
            $own_id = [func_get_arg(1)];
            $foreign_id = [func_get_arg(2)];
            $post_name = [func_get_arg(3)];
        }

        return function ($table, $post, $primaryColumn, $primary) use (
            $through_table,
            $own_id,
            $foreign_id,
            $post_name
        ) {

            /**
             * Many-to-many update first
             */
            foreach ($through_table as $index => $ttable) {

                DB::delete($ttable)
                  ->where($own_id[$index], '=', $primary)
                  ->execute();

                if (!empty($post[$post_name[$index]]) && $primary != 0) {
                    foreach ($post[$post_name[$index]] as $id) {
                        DB::insert($ttable)
                          ->values(
                              [
                                  $own_id[$index]     => $primary,
                                  $foreign_id[$index] => $id,
                              ]
                          )
                          ->execute();
                    }
                    unset($post[$post_name[$index]]);
                }
            }
            /**
             * Regular update
             */
            DB::update($table)
              ->set($post)
              ->where($primaryColumn, '=', $primary)
              ->execute();
        };
    }

    public static function getManyToManyRelationArray(
        $label,
        $options,
        $table,
        $own_key,
        $foreign_key,
        $type = 'multiselect',
        $mergeParams = []
    ) {

        //creating table in database if need
        $createIfNotExists = '
          CREATE TABLE IF NOT EXISTS `' . $table . '` (
            `' . $own_key . '` INT UNSIGNED NOT NULL ,
            `' . $foreign_key . '` INT UNSIGNED NOT NULL ,
            UNIQUE (`' . $own_key . '`, `' . $foreign_key . '`)) ENGINE = InnoDB';

        DB::query(Database::INSERT, $createIfNotExists)
          ->execute();

        $modelClassName = \Str\Str::load($table)
                                  ->remove('^[^_]+_')
                                  ->toLowerCase()
                                  ->toUpperCaseFirst()
                                  ->prepend('Model_')
                                  ->get();

        //creating model file if need
        if (!class_exists($modelClassName)) {
            $modelPath =
                APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . \Zver\StringHelper::load(
                    $modelClassName
                )
                                                                                                              ->remove(
                                                                                                                  '^[^_]+_'
                                                                                                              )
                                                                                                              ->get()
                . '.php';
            if (!file_exists($modelPath)) {
                file_put_contents(
                    $modelPath, View::factory('system/ORM_Template')
                                    ->set(
                                        'table', \Zver\StringHelper::load($table)
                                                                   ->remove('^[^_]+_')
                                                                   ->toLowerCase()
                                                                   ->toUpperCaseFirst()
                                                                   ->get()
                                    )
                );
            }

        }

        $params = [
            'dont_select'       => true,
            'label'             => $label,
            'type'              => $type,
            'options'           => $options,
            'get_current_value' => function () use ($table, $own_key, $foreign_key) {
                $request = Request::initial();
                $id = $request->param('primary');
                $current = DB::select($foreign_key)
                             ->from($table)
                             ->where($own_key, '=', $id)
                             ->execute()
                             ->as_array($foreign_key, $foreign_key);

                return $current;
            },
        ];

        return array_merge($params, $mergeParams);
    }

    public static function makeFullPathShared($path)
    {
        if (mb_substr($path, 0, mb_strlen(DOCROOT, 'UTF-8'), 'UTF-8') == DOCROOT) {
            return '/' . mb_substr($path, mb_strlen(DOCROOT, 'UTF-8'), null, 'UTF-8');
        }

        return $path;
    }

    public static function getCurrentSecondaryItem()
    {
        $request = Request::initial();
        $secondary_item_param = $request->param('secondary_item');
        if (!empty($secondary_item_param)) {
            $mainItemId = self::getCurrentMainItem();
            if (!empty($mainItemId)) {
                $secondary_items = self::getSecondaryItemsTransliterated($mainItemId);
                if (!empty($secondary_items)) {
                    foreach ($secondary_items as $key => $item) {
                        if ($item['translit'] == $secondary_item_param) {
                            return ORM::factory('SecondaryItem', $key);
                        }
                    }
                }
            }
        }

        return false;
    }

    public static function getCurrentMainItem()
    {
        $request = Request::initial();
        $main_item_param = $request->param('main_item');
        $main_items = self::getMainItemsTransliterated();
        if (!empty($main_item_param)) {
            if (in_array($main_item_param, array_column($main_items, 'translit'))) {
                foreach ($main_items as $key => $item) {
                    if ($item['translit'] == $main_item_param) {
                        return ORM::factory('MainItem', $key);
                    }
                }
            }
        }

        foreach ($main_items as $key => $item) {
            return ORM::factory('MainItem', $key);
        }
    }

    public static function getSecondaryItemsTransliterated($main_item_id = null, $activeId = null)
    {

        $key = md5($main_item_id . $activeId . __METHOD__ . Common::getCurrentLang());

        $generate = function () use ($main_item_id, $activeId) {
            $items = self::getSecondaryItems($main_item_id);
            $orm = '';
            foreach ($items as $key => &$item) {
                $orm = ORM::factory('SecondaryItem', $key);
                $item = [
                    'active'                           => (!is_null($activeId) && $activeId == $key)
                        ? true
                        : false,
                    'id'                               => $key,
                    Common::getCurrentLang() . '_name' => $item,
                    'text'                             => $item,
                    'href'                             => $orm->getHREF(),
                    'translit'                         => \Zver\StringHelper::load($orm->en_name)
                                                                            ->slugify()
                                                                            ->get(),
                ];
            }

            return $items;
        };

        return \Zver\FileCache::retrieve($key, $generate);
    }

    public static function getMainItemsTransliterated($activeId = null)
    {

        $key = md5($activeId . __METHOD__ . 'mainItems' . Common::getCurrentLang());
        $generate = function () use ($activeId) {
            $items = self::getMainItems();
            foreach ($items as $key => &$item) {
                $item = [
                    'active'                           => (!is_null($activeId) && $activeId == $key) ? true : false,
                    'id'                               => $key,
                    Common::getCurrentLang() . '_name' => $item,
                    'text'                             => $item,
                    'href'                             => ORM::factory('MainItem', $key)
                                                             ->getHREF(),
                    'translit'                         => \Zver\StringHelper::load(ORM::factory('MainItem', $key)
                                                                                       ->en_name)
                                                                            ->slugify()
                                                                            ->get(),
                ];
            }

            return $items;
        };

        return \Zver\FileCache::retrieve($key, $generate);

    }

    public static function getSecondaryItems($main_item_id = null, $as_object = null)
    {
        $items = ORM::factory('SecondaryItem')
                    ->where('visible', '=', 1)
                    ->order_by('sort');
        if (!is_null($main_item_id)) {
            $items = $items->where('main_item_id', '=', $main_item_id);
        }

        $items = $items->find_all();

        if (!is_null($as_object)) {
            return $items;
        }

        return $items->as_array('id', Common::getCurrentLang() . '_name');
    }

    public static function getMainItems($as_array = true)
    {
        $orm = ORM::factory('MainItem')
                  ->where('visible', '=', 1)
                  ->order_by('sort')
                  ->find_all();

        if ($as_array) {
            return $orm->as_array('id', Common::getCurrentLang() . '_name');
        } else {
            return $orm;
        }
    }

    public static function config($path)
    {

        if (!is_array($path)) {
            $path = [$path];
        }

        $group = array_shift($path);

        $config = Kohana::$config->load($group);

        return Arr::path($config, $path);

    }

    public static function getLangs()
    {
        return ['ru', 'en', 'am'];
    }

    public static function getDefaultLang()
    {
        return static::getLangs()[0];
    }

    public static function getCurrentLang()
    {
        $langsPriority = [
            static::getCurrentUrlLang(),
            static::getDefaultLang(),
        ];

        foreach ($langsPriority as $lang) {
            if (!empty($lang)) {
                return $lang;
            }
        }
    }

    public static function getCurrentUrlLang()
    {
        $request = Request::initial();

        return $request->param('lang', false);
    }

    public static function getChangeLangLink($lang)
    {
        $request = Request::initial();
        $route = $request->route();
        $params = $request->param();

        $params['lang'] = $lang;

        $url = URL::base() . $route->uri($params);

        $get = http_build_query($_GET);

        if (!empty($get)) {
            $url = $url . "?" . $get;
        }

        return $url;
    }

}
