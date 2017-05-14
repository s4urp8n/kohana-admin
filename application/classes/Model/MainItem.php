<?php

class Model_MainItem extends ORM
{
    use Helper;
    protected $_table_name = 'main_items';

    public function getHref()
    {
        return '/' . Common::getCurrentLang() . '/' . \Zver\StringHelper::load($this->en_name)
                                                                        ->slugify();
    }

    public function getGalleryImage()
    {
        $images = $this->getGalleryImages();
        if (!empty($images)) {
            return array_shift($images);
        }

        return [];
    }

    public function getGalleryImages()
    {
        $model = new Model_Admin_MainItems;

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Галерея');
    }

}
