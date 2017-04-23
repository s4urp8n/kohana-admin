<?php

class Task_Install extends Minion_Task
{

    protected function _execute(array $params)
    {
        \Zver\FileCache::clearAll();
        $this->createStructure();
        $this->clearPreviewsAndUploads();
        $this->insertData();
        $this->insertDump();
        \Zver\FileCache::clearAll();
    }

    protected function createStructure()
    {
        Minion_CLI::write('Creating DB structure...');
        $structureDB = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'structure.sql');

        DB::query(Database::UPDATE, $structureDB)
          ->execute();
    }

    protected function getInsertData()
    {
        $faker = Faker\Factory::create();
        $currentYear = date('Y');

        return [
            'roles'           => [
                [
                    'name'        => 'admin',
                    'description' => 'Admin role',
                ],
                [
                    'name'        => 'user',
                    'description' => 'User role',
                ],
            ],
            'roles_users'     => [
                [
                    'user_id' => 1,
                    'role_id' => 1,
                ],
            ],
            'users'           => [
                [
                    'username' => 'admin',
                    'password' => '7904532eec6591d71d09652f68690db5',
                ],
            ],
            'main_items'      => [
                [
                    'ru_name'      => 'Main',
                    'en_name'      => 'Main',
                    'module'       => Modules::$MOD_INDEX,
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'sort'         => 1,
                    'show_caption' => 1,
                    'go_child'     => 0,
                ],
                [
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                    'sort'         => 2,
                    'go_child'     => 0,
                ],
                [
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                    'sort'         => 3,
                    'go_child'     => 0,
                ],
                [
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                    'sort'         => 4,
                    'go_child'     => 0,
                ],
            ],
            'secondary_items' => [
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
                [
                    'main_item_id' => 2,
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                ],
            ],
            'main_items_2'    => [
                [
                    'ru_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'en_name'      => \Zver\StringHelper::load($faker->words(2, true))
                                                        ->toUpperCaseFirst()
                                                        ->get(),
                    'ru_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'en_content'   => implode(
                        '', array_map(
                              function ($value) {
                                  return '<p>' . $value . "</p>";
                              }, $faker->paragraphs(20)
                          )
                    ),
                    'visible'      => 1,
                    'show_caption' => 1,
                    'sort'         => 3,
                    'go_child'     => 0,
                ],
                [
                    'ru_name'      => 'Новости',
                    'en_name'      => 'News',
                    'visible'      => 1,
                    'module'       => Modules::$MOD_NEWS,
                    'show_caption' => 0,
                    'sort'         => 3,
                    'go_child'     => 0,
                ],
            ],
            'news'            => array_map(
                function ($value) use ($faker, $currentYear) {
                    return [
                        'visible'    => 1,
                        'ru_caption' => \Zver\StringHelper::load($faker->words(4, true))
                                                          ->toUpperCaseFirst()
                                                          ->get(),
                        'en_caption' => \Zver\StringHelper::load($faker->words(4, true))
                                                          ->toUpperCaseFirst()
                                                          ->get(),
                        '_datetime'  => rand($currentYear - 20, $currentYear) . $faker->date('-m-10 H:i:s'),
                        'ru_text'    => implode(
                            '', array_map(
                                  function ($value) {
                                      return '<p>' . $value . "</p>";
                                  }, $faker->paragraphs(20)
                              )
                        ),
                        'en_text'    => implode(
                            '', array_map(
                                  function ($value) {
                                      return '<p>' . $value . "</p>";
                                  }, $faker->paragraphs(20)
                              )
                        ),
                    ];
                }, range(1, 2000, 1)
            ),
            'settings'        => [
                [
                    'contact_phone'     => '+7 861 252-09-46',
                    'contact_email'     => 'farmclinic@mail.ru',
                    'contact_latitude'  => '40.703200',
                    'contact_longitude' => '-73.960990',
                ],
            ],
            'translate'       => [
                [
                    '_key'  => 'КонтактныйАдрес',
                    'ru'    => 'Россия, Краснодар, ул. Московская, 92',
                    'en'    => 'Russia, Krasnodar, Moskovskaya st., 92',
                    'strip' => 1,
                ],
                [
                    '_key'  => 'НовостейПокаНет',
                    'ru'    => 'Новостей пока нет',
                    'en'    => 'No news available yet',
                    'strip' => 1,
                ],
                [
                    '_key'  => 'НазваниеФирмыЛого',
                    'ru'    => 'ФармКлиник',
                    'en'    => 'PharmClinic',
                    'strip' => 1,
                ],
                [
                    '_key'  => 'НазваниеФирмыПодвал',
                    'ru'    => '<p>ООО "ФАРМКЛИНИК"</p>',
                    'en'    => '<p>LCC "PHARMCLINIC"</p>',
                    'strip' => 0,
                ],
                [
                    '_key'  => 'СлоганФирмы',
                    'ru'    => 'Оптовая торговля лекарственными средствами и иммунопрепаратами',
                    'en'    => 'Wholesale of medicines and drugs',
                    'strip' => 1,
                ],
                [
                    '_key'  => 'ТекстНаГлавной',
                    'ru'    => '<p>Компания "ФармКлиник" работает с 2008 года и надеется всеми усилиями и чёткой организацией работы 
                                    наладить на территории Российской Федерации надёжное снабжение лечебных учреждений, частных клиник,
                                     аптек и других потребителей предлагаемыми позициями ассортимента.</p>
                                     
                                     <p>В компании работают профессионалы высокого уровня, провизоры высшей категории с многолетним опытом работы.</p>',
                    'en'    => '<p>"PharmClinic" company operates since 2008 and hopes to all the effort and work to establish a reliable supply of hospitals, 
                                    private clinics, pharmacies and other consumers offer a range of positions.</p>
                                    
                                    <p>The company employs high level professionals, pharmacists highest category with years of experience.</p>',
                    'strip' => 0,
                ],
                [
                    '_key'  => 'ТекстОКомпанииПодвал',
                    'ru'    => 'ТекстОКомпанииПодвал',
                    'en'    => 'ТекстОКомпанииПодвал',
                    'strip' => 0,
                ],
            ],
            'index_gallery'   => [
                [
                    'ru_caption' => 'Содействие оказанию эффективной медицинской поддержки',
                    'en_caption' => 'Facilitating the provision of effective medical support',
                    'visible'    => 1,
                ],
                [
                    'ru_caption' => 'Многолетний опыт работы на рынке поставок медикаментов',
                    'en_caption' => 'Years of experience in the industry of medical supplies',
                    'visible'    => 1,
                ],
                [
                    'ru_caption' => 'Большой ассортимент вакцин, иммунопрепаратов и лекарственных средств',
                    'en_caption' => 'Large range of vaccines, drugs and medicines',
                    'visible'    => 1,
                ],
                [
                    'ru_caption' => 'В нашей компании работают только профессионалы высокого уровня с многолетним опытом работы',
                    'en_caption' => 'Only high-level professionals working in our company with years of experience',
                    'visible'    => 1,
                ],
            ],
        ];
    }

    protected function clearPreviewsAndUploads()
    {
        Minion_CLI::write('Clear previews and uploads...');

        $config = Kohana::$config->load('admin');

        $previewsDir = DOCROOT . $config->get('sharedDir') . DIRECTORY_SEPARATOR . $config->get('previewsDir');

        Minion_CLI::write('Clearing ' . $previewsDir . '...');
        $this->removePath($previewsDir);

    }

    protected function removePath($path, $callback = null, $removeSelf = false)
    {
        if (file_exists($path)) {
            if (is_file($path)) {
                if (is_null($callback) || (is_callable($callback) && $callback($path) === true)) {
                    @unlink($path);
                }
            } else {
                $iterator = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator(
                    $iterator, RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $file) {
                    if ($file->isDir()) {
                        if (is_null($callback) || (is_callable($callback) && $callback($file->getRealPath()) === true)) {
                            @rmdir($file->getRealPath());
                        }
                    } else {
                        if (is_null($callback) || (is_callable($callback) && $callback($file->getRealPath()) === true)) {
                            @unlink($file->getRealPath());
                        }
                    }
                }

                if (is_null($callback) || (is_callable($callback) && $callback($path) === true)) {
                    if ($removeSelf) {
                        @rmdir($path);
                    }
                }
            }
        }
    }

    protected function insertData()
    {
        foreach ($this->getInsertData() as $table => $data) {
            $table = \Zver\StringHelper::load($table)
                                       ->remove('_\d+$')
                                       ->get();

            Minion_CLI::write('Inserting into ' . $table . '...');
            foreach ($data as $values) {
                DB::insert($table)
                  ->columns(array_keys($values))
                  ->values($values)
                  ->execute();
            }
        }
    }

    protected function insertDump()
    {
        $dumpDir = \Zver\DirectoryWalker::fromCurrent()
                                        ->get();

        $dumpFile = $dumpDir . 'dump.sql';

        Minion_CLI::write('Inserting dump ' . $dumpFile . '...');

        DB::query(Database::UPDATE, file_get_contents($dumpFile))
          ->execute();

    }

}