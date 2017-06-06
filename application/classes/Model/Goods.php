<?php

class Model_Goods extends ORM
{

    use Helper;

    protected $_table_name = 'goods';

    public function getHref()
    {
        return '/' . Common::getCurrentLang() . '/good/' . \Zver\StringHelper::load($this->id . ' ' . $this->title_ru)
                                                                             ->slugify();
    }

    public function getImage()
    {
        $images = $this->getImages();

        return array_shift($images);
    }

    public function getImages()
    {
        $model = new Model_Admin_Goods();

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Изображение');
    }

    public function getGalleryImage()
    {
        $images = $this->getGalleryImages();

        return array_shift($images);
    }

    public function getGalleryImages()
    {
        $model = new Model_Admin_Goods();

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Галерея');
    }

}
