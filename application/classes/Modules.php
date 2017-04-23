<?php

class Modules
{

    public static $MOD_NEWS = 1;
    public static $MOD_INDEX = -100;

    final public static function render($item)
    {

        $result = '';

        $modules = self::getModules();

        if (!empty($item->module) && array_key_exists($item->module, $modules)) {

            $views = (array)$modules[$item->module]['view'];

            foreach ($views as $view => $params) {
                $params['_item'] = $item;
                $result .= View::factory($view, $params);
            }
        }

        return $result;
    }

    final public static function getModules()
    {
        return [
            self::$MOD_NEWS  => [
                'name' => 'Новости',
                'view' => [
                    'parts/news/news' => [],
                ],
            ],
            self::$MOD_INDEX => [
                'name'    => 'Главная страница',
                'view'    => [
                    'parts/index' => [],
                ],
                'options' => [
                    'no_content' => 1,
                ],
            ],
        ];
    }

    final public static function getOptions($item)
    {
        if (!empty($item->module)) {
            $modules = self::getModules();
            if (array_key_exists($item->module, $modules)) {
                if (!empty($modules[$item->module]['options'])) {
                    return $modules[$item->module]['options'];
                }
            }
        }

        return [];
    }

    final public static function getModulesKeys()
    {
        $modules = self::getModules();
        foreach ($modules as &$module) {
            $module = $module['name'];
        }
        unset($module);
        $modules = [null => null] + $modules;

        return $modules;
    }

}
