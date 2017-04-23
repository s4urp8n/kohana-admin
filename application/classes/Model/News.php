<?php

class Model_News extends ORM
{

    protected $_table_name = 'news';

    public function getHref()
    {
        return '/' . Common::getCurrentLang() . '/news/' . \Zver\StringHelper::load($this->id . ' ' . $this->ru_caption)
                                                                             ->slugify();
    }

    public function getImage()
    {
        $images = $this->getImages();

        return array_shift($images);
    }

    public function getImages()
    {
        $model = new Model_Admin_News();

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Изображение');
    }

    public function getGalleryImage()
    {
        $images = $this->getGalleryImages();

        return array_shift($images);
    }

    public function getGalleryImages()
    {
        $model = new Model_Admin_News();

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Галерея');
    }

}
