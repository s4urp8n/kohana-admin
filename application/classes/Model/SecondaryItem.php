<?php

class Model_SecondaryItem extends ORM
{

    protected $_table_name = 'secondary_items';

    public function getHref()
    {
        $parent = $this->getMainItem();

        return $parent->getHref() . '/' . \Zver\StringHelper::load($this->en_name)
                                                            ->slugify();
    }

    public function getMainItem()
    {
        return ORM::factory('MainItem', $this->main_item_id);
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
        try {
            $model = new Model_Admin_SecondaryItems;

            return Model_Admin::getSharedModelUploads($model, $this->id, 'Галерея');
        }
        catch (Exception $e) {
            return [];
        }
    }

}
