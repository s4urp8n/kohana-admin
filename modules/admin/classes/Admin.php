<?php

defined('SYSPATH') or die('No direct script access.');

class Admin
{

    public static $sessionMessageName = 'sessionMessageKey_2we23';

    public static function getPostFiles()
    {
        $files = [];
        if (!empty($_FILES)) {
            foreach ($_FILES as $directoryIndex => $uploads) {
                $files[$directoryIndex] = [];
                if (!empty($uploads['name']) && is_array($uploads['name'])) {
                    foreach ($uploads['name'] as $index => $value) {
                        $files[$directoryIndex][] = [
                            'name'     => $uploads['name'][$index],
                            'size'     => $uploads['size'][$index],
                            'type'     => $uploads['type'][$index],
                            'tmp_name' => $uploads['tmp_name'][$index],
                            'error'    => $uploads['error'][$index],
                        ];
                    }
                }
            }
        }

        return $files;
    }

    public static function setMessage($message, $messageType = 'warning')
    {
        $session = Session::instance();
        $session->set(
            self::$sessionMessageName, [
                                         'message' => $message,
                                         'type'    => $messageType,
                                     ]
        );
    }

    public static function showMessage()
    {
        $session = Session::instance();
        $message = $session->get(self::$sessionMessageName);
        $session->delete(self::$sessionMessageName);
        if (!empty($message)) {
            return View::factory(
                'Admin/Message/Template', [
                                            'message' => $message['message'],
                                            'type'    => $message['type'],
                                        ]
            );
        }

        return '';
    }

    public static function getArrayKeysValuesText(array &$array, $glue = ', ', $separator = '')
    {
        $text = '';
        $temp = '';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $temp = array_merge_recursive($value);
                $temp = implode($glue, $temp);
            } else {
                $temp = $value;
            }
            $text = $text . $key . '=[' . $temp . ']' . $separator;
        }
        $text = mb_eregi_replace('\s+', ' ', $text);

        return mb_eregi_replace('^ | $', '', $text);
    }

    public static function getProtectedUploadFilenames()
    {
        return [
            '.htaccess',
            '.gitignore',
        ];
    }

    public static function getMaximumFileUploadSize($param = null)
    {
        if (is_null($param)) {
            return min(
                self::convertPHPSizeToBytes(ini_get('post_max_size')),
                self::convertPHPSizeToBytes(ini_get('upload_max_filesize'))
            );
        }

        return min(
            $param, self::convertPHPSizeToBytes(ini_get('post_max_size')),
            self::convertPHPSizeToBytes(ini_get('upload_max_filesize'))
        );
    }

    public static function convertPHPSizeToBytes($sSize)
    {
        if (is_numeric($sSize)) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch (strtoupper($sSuffix)) {
            case 'P':
                $iValue *= 1024;
            case 'T':
                $iValue *= 1024;
            case 'G':
                $iValue *= 1024;
            case 'M':
                $iValue *= 1024;
            case 'K':
                $iValue *= 1024;
                break;
        }

        return $iValue;
    }

    public static function isAudioFile($filename)
    {
        $exts = [
            'ogg',
            'wav',
            'aac',
            'mp3',
        ];

        return self::isFileHaveExt($filename, $exts);
    }

    public static function isFileHaveExt($filename, $exts)
    {
        $ext = mb_convert_case(self::getFileExtension($filename), MB_CASE_LOWER);
        if (in_array($ext, $exts)) {
            return true;
        }

        return false;
    }

    public static function getFileExtension($filename)
    {
        $name = mb_convert_case(basename($filename), MB_CASE_LOWER);
        if (mb_strrpos($name, '.') !== false) {
            return mb_substr($name, mb_strrpos($name, '.') + 1);
        }

        return '';
    }

    public static function isImageFile($filename)
    {
        $exts = [
            'jpeg',
            'jpg',
            'bmp',
            'gif',
            'png',
            'ico',
            'svg',
        ];

        return self::isFileHaveExt($filename, $exts);
    }

    public static function createHtaccessIfNotExist($directory)
    {
    }

    public static function getFullUploadsPath()
    {
        return DOCROOT . mb_substr(self::getPublicUploadsPath(), 1);
    }

    public static function getPublicUploadsPath()
    {
        return DIRECTORY_SEPARATOR . self::getConfig('sharedDir') . DIRECTORY_SEPARATOR . self::getConfig('uploadsDir')
               . DIRECTORY_SEPARATOR;
    }

    public static function getConfig($key)
    {
        $config = Kohana::$config->load('admin');
        if (!empty($config)) {
            return $config->get($key);
        }

        return null;
    }

    public static function getUploadFileName($filename)
    {
        $file = self::translit(mb_eregi_replace('\s', '_', mb_eregi_replace('\s+', '_', $filename)));
        if (!file_exists($file)) {
            return $file;
        }
        $sep = '/';
        $postfix = '__';
        $newname = mb_eregi_replace($sep . '$', '', $file);
        $path = mb_substr($newname, 0, mb_strrpos($newname, $sep) + 1);
        $file = mb_substr($newname, mb_strrpos($newname, $sep) + 1);
        $ext = '';

        if (mb_strrpos($file, '.') !== false) {
            $ext = mb_substr($file, mb_strrpos($file, '.'));
            $file = mb_substr($file, 0, -mb_strlen($ext));
        }

        $digit = 1;
        $matches = [];
        if (mb_eregi($postfix . '(\d+)$', $file, $matches)) {
            $digit = intval($matches[1]) + 1;
            $file = mb_eregi_replace($postfix . '(\d+)$', '', $file);
        }

        $newname = $path . $file . $postfix . $digit . $ext;

        if (file_exists($newname)) {
            return self::getUploadFileName($newname);
        }

        return $newname;
    }

    public static function translit($string)
    {
        $patterns = [
            'й' => 'y',
            'ц' => 'tch',
            'у' => 'u',
            'к' => 'k',
            'е' => 'e',
            'н' => 'n',
            'г' => 'g',
            'ш' => 'sh',
            'щ' => 'sch',
            'з' => 'z',
            'х' => 'h',
            'ъ' => '',
            'ф' => 'f',
            'ы' => 'i',
            'в' => 'v',
            'а' => 'a',
            'п' => 'p',
            'р' => 'r',
            'о' => 'o',
            'л' => 'l',
            'д' => 'd',
            'ж' => 'zh',
            'э' => 'e',
            'я' => 'ya',
            'ч' => 'ch',
            'с' => 's',
            'м' => 'm',
            'и' => 'i',
            'т' => 't',
            'ь' => '',
            'б' => 'b',
            'ю' => 'u',
            'ё' => 'e',
            'Й' => 'Y',
            'Ц' => 'TCH',
            'У' => 'U',
            'К' => 'K',
            'Е' => 'E',
            'Н' => 'N',
            'Г' => 'G',
            'Ш' => 'SH',
            'Щ' => 'SCH',
            'З' => 'Z',
            'Х' => 'H',
            'Ъ' => '',
            'Ф' => 'F',
            'Ы' => 'I',
            'В' => 'V',
            'А' => 'A',
            'П' => 'P',
            'Р' => 'R',
            'О' => 'O',
            'Л' => 'L',
            'Д' => 'D',
            'Ж' => 'ZH',
            'Э' => 'E',
            'Я' => 'YA',
            'Ч' => 'CH',
            'С' => 'S',
            'М' => 'M',
            'И' => 'I',
            'Т' => 'T',
            'Ь' => '',
            'Б' => 'B',
            'Ю' => 'U',
            'Ё' => 'E',
        ];

        return strtr($string, $patterns);
    }

    public static function sortModels(&$models)
    {
        uasort(
            $models, function ($a, $b) {
            $aInfo = $a->getInfo();
            $bInfo = $b->getInfo();
            $aInfo = $aInfo['caption'];
            $bInfo = $bInfo['caption'];

            return strnatcasecmp($aInfo, $bInfo);
        }
        );
    }

    public static function createDirectoryIfNotExists($directory, $mode = 0777)
    {
        if (!file_exists($directory)) {
            mkdir($directory, $mode, true);
        }
    }

    public static function scanModels()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . 'Admin';
        $lowerDir = __DIR__ . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'admin';
        $commonDir =
            APPPATH . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . 'Admin';
        $lowerCommonDir =
            APPPATH . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'admin';

        $models = array_merge(
            self::scanDirForModels($dir), self::scanDirForModels($commonDir), self::scanDirForModels($lowerCommonDir),
            self::scanDirForModels($lowerDir)
        );
        self::filterAllowed($models);
        self::filterVisible($models);

        return $models;
    }

    public static function scanDirForModels($dir)
    {
        $models = self::getScandir($dir);

        $exp = [];
        foreach ($models as $key => $model) {
            if (mb_eregi('(\w+)\.\w+', $model, $exp)) {
                $modelName = $exp[1];
                $fullModelName = 'Model_Admin_' . $modelName;

                $model = self::createModel($fullModelName);
                if (!empty($model) && $model instanceof Model_Admin) {
                    $models[$modelName] = $model;
                }
                unset($models[$key]);
            }
        }

        return $models;
    }

    public static function filterAllowed(&$models)
    {
        foreach ($models as $key => $model) {
            if (!$model->isAllowed()) {
                unset($models[$key]);
            }
        }
    }

    public static function filterVisible(&$models)
    {
        foreach ($models as $key => $model) {
            if (method_exists($model, 'isVisible')) {
                if (!$model->isVisible()) {
                    unset($models[$key]);
                }
            }
        }
    }

    public static function getScandir($directory, $searchString = null, $reverseSort = false, $withDir = false)
    {
        if (file_exists($directory) && is_dir($directory)) {

            $contents = scandir($directory);
            array_shift($contents);
            array_shift($contents);

            foreach ($contents as $key => $value) {
                if (!is_file(Text::reduce_slashes($directory . DIRECTORY_SEPARATOR . $value))
                    || !self::isAllowedFile(
                        $value
                    )
                    || (!empty($searchString) && stripos($value, $searchString) === false)
                ) {
                    unset($contents[$key]);
                }
            }

            uasort(
                $contents, function ($a, $b) use ($directory) {
                $sort = 0;
                $aDate = filemtime(Text::reduce_slashes($directory . DIRECTORY_SEPARATOR . $a));
                $bDate = filemtime(Text::reduce_slashes($directory . DIRECTORY_SEPARATOR . $b));
                if ($aDate === $bDate) {
                    return strnatcasecmp($a, $b);
                } else {
                    return strnatcasecmp($aDate, $bDate);
                }
            }
            );

            if ($withDir === true) {

                if (!in_array(mb_substr($directory, -1), ['\\', '/'])) {
                    $directory = $directory . DIRECTORY_SEPARATOR;
                }
                foreach ($contents as $key => $content) {
                    $contents[$key] = $directory . $content;
                }
            }

            if ($reverseSort === true) {
                return $contents;
            } else {
                return array_reverse($contents);
            }
        }

        return [];
    }

    public static function createModel($modelName)
    {
        $model = false;
        $reflection = new ReflectionClass($modelName);
        if (class_exists($modelName) && !$reflection->isAbstract()) {
            try {
                $model = new $modelName();
            }
            catch (Exception $e) {
                return false;
            }
        }

        return $model;
    }

    public static function isAllowedFile($filename)
    {
        $allowed = true;
        $restricted = self::getRestrictedUploadFilenames();
        if (!empty($restricted)) {
            foreach ($restricted as $rule) {
                if (is_array($rule) && mb_eregi($rule[0], $filename) || $filename == $rule) {
                    $allowed = false;
                    break;
                }
            }
        }

        return $allowed;
    }

    public static function getRestrictedUploadFilenames()
    {
        return [
            '.htaccess',
            '.gitignore',
            ['^\s*\..*'],
        ];
    }

}
