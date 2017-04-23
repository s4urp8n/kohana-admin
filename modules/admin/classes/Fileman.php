<?php

defined('SYSPATH') or die('No direct script access.');

class Fileman
{

    public static function render()
    {
        self::checkDir();
        $current = self::getCurrentDir();
        $fullCurrent = self::getRootDir() . $current;

        $content = self::getScanDir($fullCurrent);

        printDie($content);
    }

    public static function checkDir()
    {
        if (!file_exists(self::getRootDir())) {
            mkdir(self::getRootDir(), 0755, true);
        }
    }

    public static function getCurrentDir()
    {
        $request = Request::initial();
        $path = $request->query('path');
        $path = \Str\Str::load($path)
                        ->remove('\.{2}');
        if (!empty($path)) {
            return $path;
        }

        return '';
    }

    public static function getRootDir()
    {
        return DOCROOT . Admin::getConfig('sharedDir') . DIRECTORY_SEPARATOR . Admin::getConfig('uploadsDir')
               . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    }

    public static function getScanDir($directory)
    {
        $content = scandir($directory);
        array_shift($content);
        array_shift($content);

        $result = [
            'folders' => [],
            'files'   => [],
        ];
        $temp = '';
        foreach ($content as $some) {
            $temp = \Str\Str::load($directory)
                            ->setEnding(DIRECTORY_SEPARATOR)
                            ->append($some);
            if (is_file($temp)) {
                $result['files'][] = $temp;
            } else {
                $result['folders'][] = $temp;
            }
        }

        return $content;
    }

}
