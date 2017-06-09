<?php

class Task_Translate extends Minion_Task
{

    protected function translate($text, $from, $to)
    {
        $keys = [
            'trnsl.1.1.20160422T121616Z.cf6be9f687de2583.5a5337a2b2e889f087d843cacb80e88ff8ad882d',
            'trnsl.1.1.20160416T124034Z.cb7352a6952c957b.d9fe49ed9fdadb37785431d2046c559255d4f13c',
            'trnsl.1.1.20160416T123736Z.ca4d46188807fe71.178186ce51bd8ed1c0b2a7177c0585b280350ef5',
            'trnsl.1.1.20160416T124347Z.e3748b2322624334.87a24c7c4ed8d3d598a663e78916fc5f83e7fd61',
            'trnsl.1.1.20160416T124433Z.076f20c4107af545.a544aecaec177755b7ff46ad74c2be50f3a3edeb',
            'trnsl.1.1.20160416T124547Z.1cd585a45d618e56.cc1ff06db0886c4be0a672e566cd9ecee18f7a71',
            'trnsl.1.1.20160416T124637Z.9cd9cda09358ef12.76696be74bdf49ff7042413e3ab6ac36eef450aa',
            'trnsl.1.1.20160422T121421Z.2b1fb47bf972f13d.e148582470a8721afbc08d491f7f227e72526dd7',
        ];

        foreach ($keys as $key) {

            try {

                $translation = null;

                $translator = new \Yandex\Translate\Translator($key);
                $translation = $translator->translate($text, $from . '-' . $to);

            }
            catch (\Exception $e) {
                $translation = null;
            }

            if (!empty($translation)) {
                return implode(' ', $translation->getResult());
            }
        }

        return false;
    }

    protected function _execute(array $params)
    {

        $langs = [
            'en' => 'en',
            'am' => 'hy',
        ];

        $haveLang = 'ru';
        $haveLangAlias = 'ru';

        $needTranslate = [
            'articles_categories' => ['name', 'description'],
            'articles'            => ['name', 'description'],
            'translate'           => [''],
            'shop_categories'     => ['name', 'description', 'title', 'keywords'],
            'goods'               => ['title', 'description'],
            'index_gallery'       => ['caption'],
            'main_items'          => ['name', 'content', 'title', 'description', 'keywords'],
            'secondary_items'     => ['name', 'content', 'title', 'description', 'keywords'],
            'news'                => ['text', 'caption', 'description', 'keywords', 'title'],
        ];

        foreach ($needTranslate as $table => $fields) {

            $items = DB::select()
                       ->from($table)
                       ->execute()
                       ->as_array();

            if (!empty($items)) {

                foreach ($langs as $dbLang => $translateLang) {

                    foreach ($fields as $field) {

                        $variants = [
                            $dbLang,
                            $dbLang . '_' . $field,
                            $field . '_' . $dbLang,
                        ];

                        $variantsOriginal = [
                            $haveLang,
                            $haveLang . '_' . $field,
                            $field . '_' . $haveLang,
                        ];

                        foreach ($variants as $variant) {
                            foreach ($variantsOriginal as $variantOriginal) {
                                foreach ($items as $item) {

                                    if (
                                        array_key_exists($variant, $item) &&
                                        array_key_exists('id', $item) &&
                                        array_key_exists($variantOriginal, $item)
                                    ) {

                                        $value = $item[$variant];
                                        $original = $item[$variantOriginal];

                                        if (empty($value) && !empty($original)) {

                                            echo 'Translating ' . $variant . ' of ' . $table . ' with id=' . $item['id'] . "\n";

                                            $translation = $this->translate($original, $haveLangAlias, $translateLang);

                                            if ($translation) {

                                                DB::update($table)
                                                  ->set([$variant => $translation])
                                                  ->where('id', '=', $item['id'])
                                                  ->execute();

                                            }

                                        }

                                    }
                                }

                            }
                        }

                    }
                }

            }
        }

    }

}