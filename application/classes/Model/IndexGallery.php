<?php

class Model_IndexGallery extends ORM
{
    protected $_table_name = 'index_gallery';

    public function getImage()
    {
        $images = $this->getImages();

        return array_shift($images);
    }

    public function getImages()
    {
        $model = new Model_Admin_IndexGallery();

        return Model_Admin::getSharedModelUploads($model, $this->id, 'Картинка1020x300');
    }
}
