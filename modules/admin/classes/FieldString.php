<?php

/**
 * @author s4urp8n@yandex.ru
 */
class FieldString
{

    private static $encoding = 'UTF-8';

    public static function translateMonthRuFromNumber($number)
    {
        $number = intval($number);
        $ru = [
            1  => 'Январь',
            2  => 'Февраль',
            3  => 'Март',
            4  => 'Апрель',
            5  => 'Май',
            6  => 'Июнь',
            7  => 'Июль',
            8  => 'Август',
            9  => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];

        if (array_key_exists($number, $ru)) {
            return $ru[$number];
        }

        return false;
    }

    public static function getFullRuDateFromMysqlDate($mysqlDate)
    {
        $date = null;
        if (mb_eregi('^\d{4,}-\d{2}-\d{2}$', $mysqlDate)) {
            $date = DateTime::createFromFormat('Y-m-d', $mysqlDate);
        } elseif (mb_eregi('^\d{4,}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', $mysqlDate)) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $mysqlDate);
        }

        if (is_null($date)) {
            return false;
        } else {
            return $date->format('j') . ' ' . self::translateMonthRuEn($date->format('F')) . ' ' . $date->format('Y');
        }
    }

    public static function translateMonthRuEn($month)
    {
        $m = \Zver\StringHelper::load($month)
                               ->toLowerCase()
                               ->get();
        $ru = [
            'january'   => 'января',
            'february'  => 'февраля',
            'march'     => 'марта',
            'april'     => 'апреля',
            'may'       => 'мая',
            'june'      => 'июня',
            'july'      => 'июля',
            'august'    => 'августа',
            'september' => 'сентября',
            'october'   => 'октября',
            'november'  => 'ноября',
            'december'  => 'декабря',
        ];

        return strtr($m, $ru);
    }

    public static function translateMonthToArmenian($month)
    {
        $m = \Zver\StringHelper::load($month)
                               ->toLowerCase();

        $ru = [
            'январ(я|ь)'   => 'հունվարի',
            'феврал(я|ь)'  => 'փետրվար',
            'марта?'       => 'երթ',
            'апрел(я|ь)'   => 'ապրիլ',
            'ма(я|й)'      => 'մայիս',
            'июн(я|ь)'     => 'հունիսի',
            'июл(я|ь)'     => 'հուլիսի',
            'августа?'     => 'օգոստոս',
            'сентябр(я|ь)' => 'սեպտեմբեր',
            'октябр(я|ь)'  => 'հոկտեմբեր',
            'ноябр(я|ь)'   => 'նոյեմբեր',
            'декабр(я|ь)'  => 'դեկտեմբեր',
        ];

        foreach ($ru as $pattern => $replace) {
            $m->replace($pattern, $replace);
        }

        return $m->get();
    }

    public static function translateMonthToEnglish($month)
    {
        $m = \Zver\StringHelper::load($month)
                               ->toLowerCase();

        $ru = [
            'январ(я|ь)'   => 'January',
            'феврал(я|ь)'  => 'February',
            'марта?'       => 'March',
            'апрел(я|ь)'   => 'April',
            'ма(я|й)'      => 'May',
            'июн(я|ь)'     => 'June',
            'июл(я|ь)'     => 'July',
            'августа?'     => 'August',
            'сентябр(я|ь)' => 'September',
            'октябр(я|ь)'  => 'October',
            'ноябр(я|ь)'   => 'November',
            'декабр(я|ь)'  => 'December',
        ];

        foreach ($ru as $pattern => $replace) {
            $m->replace($pattern, $replace);
        }

        return $m->get();
    }

    public static function getEmailBase($email)
    {
        return mb_substr($email, 0, mb_strpos($email, '@', 0, self::$encoding), self::$encoding);
    }

}
