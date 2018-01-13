<?php

namespace App {

    use Illuminate\Support\Facades\Log;
    use Zver\StringHelper;

    class Config
    {

        public static function isUrlActive($url, $baseUrl = null, $host = null)
        {
            if (is_null($host)) {
                $host = $_SERVER['HTTP_HOST'];
            }

            if (is_null($baseUrl)) {
                $baseUrl = url()->current();
            }

            $currentUrl = StringHelper::load($baseUrl)
                                      ->remove('\w+:\/+')
                                      ->removeBeginning($host);

            $targetUrl = StringHelper::load($url)
                                     ->remove('\w+:\/+')
                                     ->removeBeginning($host);

            if ($targetUrl->isEquals('/') && $currentUrl->isEquals('/')
                ||
                $targetUrl->isEquals('/') && $currentUrl->isEquals('')
                ||
                $targetUrl->isEquals('') && $currentUrl->isEquals('/')
                ||
                $targetUrl->isEquals('') && $currentUrl->isEquals('')
            ) {
                return true;
            }

            if ($targetUrl->isEquals('/') || $currentUrl->isEquals('/')) {
                return false;
            }

            $targetUrl->removeBeginning('/')
                      ->setFirstPart('/');
            $currentUrl->removeBeginning('/')
                       ->setFirstPart('/');

            if ($targetUrl->isEquals($currentUrl)) {
                return true;
            }

            return false;
        }

        public static function getMenu()
        {
            return [
                [
                    'href' => '/',
                    'name' => 'Главная',
                ],
                [
                    'href' => '/catalog',
                    'name' => 'Каталог',
                ],
//                [
//                    'href' => '/news',
//                    'name' => 'Новости',
//                ],
                [
                    'href' => '/about',
                    'name' => 'О компании',
                ],
                [
                    'href' => '/contacts',
                    'name' => 'Контакты',
                ],
            ];
        }

    }

}