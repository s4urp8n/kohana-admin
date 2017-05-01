<?php

function getAssetsVersion()
{
    return file_get_contents(DOCROOT . 'version.txt');
}

function ___($key)
{

    $translate = ORM::factory('Translate')
                    ->where('_key', '=', $key)
                    ->find();

    if (empty($translate->id)) {
        $row = new Model_Translate();
        $row->_key = $key;
        $row->save();
    } else {
        $text = $translate->get(Common::getCurrentLang());
        if (!empty($text)) {
            if ($translate->strip == 1) {
                return strip_tags($text);
            }

            return $text;
        }
    }

    return $key;
}

function getFileContent($path)
{
    return file_get_contents(\Zver\Common::replaceSlashesToPlatformSlashes(DOCROOT . $path));
}

function printDie()
{

    $args = func_get_args();

    foreach ($args as $arg) {
        echo "<pre>";

        if (is_array($arg)) {
            print_r($arg);
        } elseif (is_object($arg)) {
            var_dump($arg);
        } else {
            echo $arg;
        }
        echo "</pre>";
    }
    die();
}

function array_parts(&$array, $number_of_parts)
{

    $result = [];
    $i = 0;
    foreach ($array as $a) {

        if (!array_key_exists($i, $result)) {
            $result[$i] = [];
        }

        $result[$i][] = $a;

        $i++;
        if ($i >= $number_of_parts) {
            $i = 0;
        }
    }

    return $result;
}

if (!function_exists('array_column')) {

    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);

            return null;
        }

        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING
            );

            return null;
        }

        if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);

            return false;
        }

        if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2])
            && !(is_object(
                     $params[2]
                 )
                 && method_exists(
                     $params[2], '__toString'
                 ))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);

            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null)
            ? (string)$params[1]
            : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int)$params[2];
            } else {
                $paramsIndexKey = (string)$params[2];
            }
        }

        $resultArray = [];

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string)$row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }

        return $resultArray;
    }

}
