<?php

defined('SYSPATH') or die('No direct script access.');

class ImagePreview
{

    public static function findPreviews($originalImage)
    {
        $dir = self::getPreviewsDir();
        $previews = scandir($dir);
        array_shift($previews);
        array_shift($previews);
        $pattern = md5_file($originalImage);
        $params = [];
        foreach ($previews as $key => $preview) {
            if (!mb_eregi('^' . $pattern, $preview)) {
                unset($previews[$key]);
            } else {
                $params = explode('x', mb_substr(mb_substr($preview, 33), 0, -4));
                $previews[$key] = [
                    'width'       => $params[0],
                    'height'      => $params[1],
                    'previewFile' => $dir . $pattern . '_' . $params[0] . 'x' . $params[1] . '.png',
                ];
            }
        }

        return $previews;
    }

    private static function getPreviewsDir()
    {
        $sharedDir = Admin::getConfig('sharedDir');
        $previewDir = Admin::getConfig('previewsDir');

        return DOCROOT . $sharedDir . DIRECTORY_SEPARATOR . $previewDir . DIRECTORY_SEPARATOR;
    }

    /**
     * Removes previews from previews directory.
     * If no arguments passed - removes ALL available previews.
     *
     * @param string $originalImage
     */
    public static function removePreviews($originalImage = null)
    {

        $dir = self::getPreviewsDir();

        if (file_exists($dir) && is_dir($dir)) {

            $md5 = null;
            if (!is_null($originalImage)) {
                $md5 = md5_file($originalImage);
            }

            $previews = scandir($dir);
            array_shift($previews); //.
            array_shift($previews); //..

            foreach ($previews as $preview) {
                if (is_file($dir . $preview) && Admin::isImageFile($preview)
                    && (is_null($originalImage)
                        || mb_eregi(
                            '^' . $md5, $preview
                        ))
                ) {
                    unlink($dir . $preview);
                }
            }
        }
    }

    public static function getPreview(
        $originalImage,
        $previewWidth,
        $previewHeight,
        $shared = true,
        $fill = '#ffffff',
        $cut = false
    ) {

        $original = $originalImage;

        //relative path
        if (!\Zver\StringHelper::load($original)
                               ->isStartsWith(DOCROOT)
        ) {
            //remove heading slashes
            if (mb_substr($original, 0, 1) == '/' || mb_substr($original, 0, 1) == '\\') {
                $original = mb_substr($original, 1);
            }
            $original = DOCROOT . $original;
        }

        Admin::createDirectoryIfNotExists(self::getPreviewsDir());

        if (file_exists($original)) {
            $previewName = self::getPreviewName($original, $previewWidth, $previewHeight, $fill, $cut);

            if (!file_exists($previewName)) {
                self::createPreview($original, $previewWidth, $previewHeight, $fill, $cut);
            }

            if ($shared === true) {
                return mb_substr($previewName, mb_strlen(DOCROOT) - 1);
            }

            return $previewName;
        } else {
            throw new Exception('Image file ' . $original . ' not found!');
        }
    }

    private static function getPreviewName(
        $originalImage,
        $previewWidth,
        $previewHeight,
        $fill = '#ffffff',
        $cut = false
    ) {
        return self::getPreviewsDir() . sha1(
                md5(md5_file($originalImage)) . '_' . $previewWidth . 'x' . $previewHeight . '_' . md5($fill) . '_' . ($cut
                    ? 'cutxxx'
                    : 'uncutxxx')
            ) . '.png';
    }

    private static function createPreview($image, $previewWidth, $previewHeight, $fill = '#ffffff', $cut = false)
    {

        $previewName = self::getPreviewName($image, $previewWidth, $previewHeight, $fill, $cut);
        $img = Image::factory($image);

        if ($cut) {
            $ratio = $img->width / $img->height;
            $original_ratio = $previewWidth / $previewHeight;
            $crop_width = $img->width;
            $crop_height = $img->height;
            if ($ratio > $original_ratio) {
                $crop_width = round($original_ratio * $crop_height);
            } else {
                $crop_height = round($crop_width / $original_ratio);
            }
            $img->crop($crop_width, $crop_height);
            $img->resize($previewWidth, $previewHeight, Image::NONE);
            $img->save($previewName);
        } else {
            $img->resize($previewWidth, $previewHeight)
                ->save($previewName);

            $imgSuper = Super_Image::create($previewWidth, $previewHeight)
                                   ->fill($fill)
                                   ->combineCentered(Super_Image::load($previewName))
                                   ->save($previewName);
        }

    }

}
