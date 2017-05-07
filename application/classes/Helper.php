<?php

trait Helper
{

    public function renderGallery()
    {
        if (method_exists($this, 'getGalleryImages')) {

            $images = [];
            $videos = [];

            try {
                $images = $this->getGalleryImages();
            }
            catch (Exception $e) {

            }

            if (!empty($this->videos)) {
                $videos = explode(',', $this->videos);
            }

            if (!empty($images) || !empty($videos)) {
                echo View::factory('parts/photos', [
                    'videos' => $videos,
                    'images' => $images,
                ]);
            }
        }
    }

}