<?php

/**
 * @author s4urp8n@yandex.ru
 */
class FishText
{

    private static $defaultBeetween = ' ';
    private static $defaultSentenceBeetween = ' ';
    private static $betweens = ['-', ' - ', ': ', ', ',];
    private static $defaultEnd = '.';
    private static $ends = ['!', '?',];
    private static $consonants = 'qwrtpsdfghjklzxcvbnm';
    private static $vowels = 'aeyuio';
    //    private static $consonants = 'цкнгшщзхфвпрлджчсмтб';
    //    private static $vowels = 'уеыаоёэяию';
    private static $wordPartsMin = 2;
    private static $wordPartsMax = 3;
    private static $wordsInversedPartProbability = 2;
    private static $sentenceWordsMin = 3;
    private static $sentenceWordsMax = 20;
    private static $paragraphSentencesMin = 7;
    private static $paragraphSentencesMax = 20;
    private static $defaultProbability = 50;
    private static $otherEndProbability = 5;
    private static $otherBetweenProbability = 5;

    public static function getNumber($min = 1, $max = 100)
    {
        return rand($min, $max);
    }

    public static function getUcFirstWord()
    {
        return self::ucfirst(self::getWord());
    }

    private static function ucfirst($string)
    {
        return mb_convert_case(mb_substr($string, 0, 1, 'UTF-8'), MB_CASE_UPPER, 'UTF-8') . mb_convert_case(
                mb_substr($string, 1, mb_strlen($string), 'UTF-8'), MB_CASE_LOWER, 'UTF-8'
            );
    }

    public static function getWord()
    {

        $word = '';
        $iteration = rand(self::$wordPartsMin, self::$wordPartsMax);

        for ($i = 0; $i < $iteration; $i++) {
            if (self::is(100 - self::$wordsInversedPartProbability)) {
                $word .= self::getStringRandomChar(self::$consonants) . self::getStringRandomChar(self::$vowels);
            } else {
                $word .= self::getStringRandomChar(self::$vowels) . self::getStringRandomChar(self::$consonants);
            }
        }

        return $word;
    }

    private static function is($persentage = null)
    {
        if (empty($persentage) || !is_numeric($persentage)) {
            return rand(1, 100) <= self::$defaultProbability;
        }

        return rand(1, 100) <= $persentage;
    }

    private static function getStringRandomChar($string)
    {
        if (empty($string)) {
            return false;
        }

        $length = mb_strlen($string, 'UTF-8');
        if ($length == 1) {
            return $string;
        }

        $index = rand(0, $length - 1);

        return mb_substr($string, $index, 1, 'UTF-8');
    }

    public static function getDate()
    {
        if (self::is()) {
            return self::getPastDate();
        }

        return self::getFutureDate();
    }

    public static function getPastDate($format = 'Y-m-d')
    {
        $date = new DateTime();

        $date->modify('-' . rand(1, 100) . ' day');
        $date->modify('-' . rand(1, 5) . ' month');
        $date->modify('-' . rand(1, 5) . ' year');

        return $date->format($format);
    }

    public static function getFutureDate($format = 'Y-m-d')
    {
        $date = new DateTime();

        $date->modify('+' . rand(1, 100) . ' day');
        $date->modify('+' . rand(1, 5) . ' month');
        $date->modify('+' . rand(1, 5) . ' year');

        return $date->format($format);
    }

    public static function get24HoursTime($separator = ':', $seconds = false)
    {

        $time = str_pad(rand(0, 23), 2, '0', STR_PAD_LEFT) . $separator . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);

        if ($seconds) {
            $time .= $separator . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
        }

        return $time;
    }

    public static function getParagraph()
    {
        $sentencesCount = rand(self::$paragraphSentencesMin, self::$paragraphSentencesMax);

        $sentences = [];

        for ($i = 0; $i < $sentencesCount; $i++) {
            $sentences[] = self::getSentence();
        }

        return implode(self::$defaultSentenceBeetween, $sentences);
    }

    public static function getSentence()
    {
        $sentence = self::ucfirst(self::getWord());
        $wordsCount = rand(self::$sentenceWordsMin, self::$sentenceWordsMax) - 1;

        for ($i = 0; $i < $wordsCount; $i++) {
            $sentence .= self::getBetween() . self::getWord();
        }

        return $sentence . self::getSentenceEnd();
    }

    public static function getBetween()
    {
        if (self::is(self::$otherBetweenProbability)) {
            return self::$betweens[array_rand(self::$betweens)];
        }

        return self::$defaultBeetween;
    }

    public static function getSentenceEnd()
    {
        if (self::is(self::$otherEndProbability)) {
            return self::$ends[array_rand(self::$ends)];
        }

        return self::$defaultEnd;
    }

}
