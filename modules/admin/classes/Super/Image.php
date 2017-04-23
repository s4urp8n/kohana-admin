<?php

/**
 * Class to manipulate images
 */
class Super_Image
{
    
    protected static $default_format = 'png';
    protected static $default_background = 'none';
    protected $width = 0;
    protected $height = 0;
    protected $imagick = null;
    protected $background = null;
    
    /**
     * Use function create(),load() or factory() to instantiate.
     */
    private function __construct()
    {
        
        $args = func_get_args();
        
        $args_count = func_num_args();
        
        if ($args_count == 1)
        {
            $this->imagick = new \Imagick;
            if (file_exists($args[0]))
            {
                $this->imagick->readImage($args[0]);
                $this->update();
            }
            else
            {
                throw new \Exception('Image file "' . $args[0] . '" not exists');
            }
        }
        elseif ($args_count == 2 && is_numeric($args[0]) && $args[0] >= 1 && is_numeric($args[1]) && $args[1] >= 1)
        {
            $this->imagick = new \Imagick;
            $this->imagick->newimage($args[0], $args[1], self::$default_background, self::$default_format);
            $this->width = $args[0];
            $this->height = $args[1];
        }
        else
        {
            throw new \Exception('Wrong params passed to \Abstractor\Image constructor');
        }
    }
    
    /**
     * Update information about current image
     */
    private function update()
    {
        $this->width = $this->imagick->getimagewidth();
        $this->height = $this->imagick->getimageheight();
    }
    
    /**
     * Synonim of load() method
     *
     * @param string $filename
     *
     * @return image
     */
    public static function factory($filename)
    {
        return self::load($filename);
    }
    
    /**
     * Load image file from filesystem.
     *
     * @param string $filename
     *
     * @return image
     */
    public static function load($filename)
    {
        return new self($filename);
    }
    
    /**
     * Set background color of current instance.
     * This method not fill image.
     *
     * @param string $color
     *
     * @return image
     */
    public function setBackground($color)
    {
        $this->background = new \ImagickPixel($color);
        
        return $this;
    }
    
    /**
     * Set image format of current instance.
     *
     * @param string $format
     *
     * @return image
     */
    public function setFormat($format)
    {
        $this->imagick->setimageformat($format);
        
        return $this;
    }
    
    /**
     * Flip current image horizontally
     *
     * @return image
     */
    public function flipHorizontal()
    {
        $this->imagick->flopimage();
        
        return $this;
    }
    
    /**
     * Flip current image vertically
     *
     * @return image
     */
    public function flipVertical()
    {
        $this->imagick->flipimage();
        
        return $this;
    }
    
    /**
     * Flip current image vertically and horizontally
     *
     * @return image
     */
    public function flipBoth()
    {
        $this->imagick->flopimage();
        $this->imagick->flipimage();
        
        return $this;
    }
    
    /**
     * Fill transparent current instance image
     *
     * @return image
     */
    public function clear()
    {
        return self::create($this->width, $this->height);
    }
    
    /**
     * Create new transparent image $width x $height
     *
     * @param int $width
     * @param int $height
     *
     * @return image
     */
    public static function create($width, $height)
    {
        return new self($width, $height);
    }
    
    /**
     * Fill image with $color
     *
     * @param string $color
     *
     * @return image
     */
    public function fill($color)
    {
        return $this->fillRectangle($color);
    }
    
    /**
     * Draw filled rectangle on current image
     *
     * @param string $color
     * @param int    $x
     * @param int    $y
     * @param int    $width
     * @param int    $height
     * @param float  $opacity
     *
     * @return image
     */
    public function fillRectangle($color, $x = 0, $y = 0, $width = null, $height = null, $opacity = 1)
    {
        $width = (is_null($width))
            ? $this->width
            : $width;
        $height = (is_null($height))
            ? $this->height
            : $height;
        $fill_rect = new \ImagickDraw;
        $fill_rect->setfillcolor(new \ImagickPixel($color));
        $fill_rect->setfillopacity($opacity);
        $fill_rect->rectangle($x, $y, $x + $width, $y + $height);
        $this->imagick->drawimage($fill_rect);
        
        return $this;
    }
    
    /**
     * Draw filled circle on current image
     *
     * @param string $color
     * @param int    $center_x
     * @param int    $center_y
     * @param int    $radius
     * @param float  $opacity
     *
     * @return image
     */
    public function fillCircle($color, $center_x, $center_y, $radius, $opacity = 1)
    {
        
        $fill = new \ImagickDraw;
        $fill->setfillcolor(new \ImagickPixel($color));
        $fill->setfillopacity($opacity);
        $fill->ellipse($center_x, $center_y, $radius, $radius, 0, 360);
        $this->imagick->drawimage($fill);
        
        return $this;
    }
    
    /**
     * Draw filled arc on current instance image
     *
     * @param string $stroke_color
     * @param string $fill_color
     * @param int    $stroke_width
     * @param int    $start_x
     * @param int    $start_y
     * @param int    $end_x
     * @param int    $end_y
     * @param int    $start_angle
     * @param int    $end_angle
     * @param float  $opacity
     *
     * @return image
     */
    public function fillArc(
        $stroke_color, $fill_color, $stroke_width, $start_x, $start_y, $end_x, $end_y, $start_angle = 0,
        $end_angle = 360, $opacity = 1
    ) {
        
        $fill = new \ImagickDraw();
        $fill->setStrokeWidth($stroke_width);
        $fill->setStrokeColor($stroke_color);
        $fill->setFillColor($fill_color);
        $fill->arc($start_x, $start_y, $end_x, $end_y, $start_angle, $end_angle);
        $this->imagick->drawimage($fill);
        
        return $this;
    }
    
    /**
     * Scales image keep aspect ration
     *
     * @param float $ratio
     *
     * @return image
     */
    public function scale($ratio)
    {
        $this->imagick->scaleimage($this->width * $ratio, $this->height * $ratio);
        $this->update();
        
        return $this;
    }
    
    public function repeatHorizontal($width)
    {
        $this->resize();
        
        return $this;
    }
    
    /**
     * Merge current image and $image by centers
     *
     * @param image $image
     *
     * @return image
     */
    public function combineCentered(Super_Image $image)
    {
        $image_x_offset = 0;
        $image_y_offset = 0;
        
        $image_w = $image->width();
        $image_h = $image->height();
        
        $w = $this->width();
        $h = $this->height();
        
        if ($image_w > $w)
        {
            $image_x_offset = -($image_w / 2 - $w / 2);
        }
        else
        {
            $image_x_offset = $w / 2 - $image_w / 2;
        }
        
        if ($image_h > $h)
        {
            $image_y_offset = -($image_h / 2 - $h / 2);
        }
        else
        {
            $image_y_offset = $h / 2 - $image_h / 2;
        }
        
        return $this->combine($image, $image_x_offset, $image_y_offset);
    }
    
    /**
     * Get current image width.
     *
     * @return int
     */
    public function width()
    {
        return $this->width;
    }
    
    /**
     * Get current image height.
     *
     * @return int
     */
    public function height()
    {
        return $this->height;
    }
    
    /**
     * Merge current image and $image
     *
     * @param image $image
     * @param int   $image_x_offset
     * @param int   $image_y_offset
     *
     * @return image
     */
    public function combine(Super_Image $image, $image_x_offset = 0, $image_y_offset = 0)
    {
        $this->imagick->compositeimage(
            $image->getImagick(), IMAGICK::COMPOSITE_DEFAULT, $image_x_offset, $image_y_offset
        );
        $this->update();
        
        return $this;
    }
    
    /**
     * Get current instance imagick object.
     *
     * @return imagick
     */
    public function getImagick()
    {
        return $this->imagick;
    }
    
    /**
     * Replace current image with $image
     *
     * @param image $image
     *
     * @return image
     */
    public function replace(Super_Image $image)
    {
        $this->imagick = $image->getImagick();
        $this->update();
        
        return $this;
    }
    
    /**
     * Leave in image only pixels inside of rectangle:
     *
     * @param int $x      x coordinate of rectangle left top corner
     * @param int $y      y coordinate of rectangle left top corner
     * @param int $width  rectangle width
     * @param int $height rectangle height
     *
     * @return image
     */
    public function crop($x, $y, $width, $height)
    {
        $this->imagick->cropimage($width, $height, $x, $y);
        $this->width = $width;
        $this->height = $height;
        
        return $this;
    }
    
    /**
     * Function try to fit image to new width and height
     *
     * @param int  $width
     * @param int  $height
     * @param bool $show
     *
     * @return image
     */
    public function preview($width, $height, $show = true)
    {
        $this->imagick->cropthumbnailimage($width, $height);
        if ($show)
        {
            $this->show();
        }
        
        return $this;
    }
    
    /**
     * Output current image to browser
     */
    public function show()
    {
        header('Content-Type: image/' . $this->imagick->getimageformat());
        echo $this->render();
    }
    
    /**
     * Get string representation of current image
     *
     * @return string
     */
    public function render()
    {
        ob_start();
        echo $this->imagick;
        
        return ob_get_clean();
    }
    
    /**
     * Rotate image. Sometimes size of image changes.
     *
     * @param int $angle
     *
     * @return image
     */
    public function rotate($angle)
    {
        $this->imagick->rotateimage(
            is_null($this->background)
                ? self::$default_background
                : $this->background, $angle
        );
        $this->update();
        
        return $this;
    }
    
    /**
     * Get base64 encoded data uri representation of current image
     *
     * @return string
     */
    public function dataURL()
    {
        return 'data: image/' . $this->imagick->getimageformat() . ';base64,' . base64_encode($this->render());
    }
    
    /**
     * Get string representation of current image
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
    
    public function save($filename)
    {
        $this->imagick->writeImage($filename);
        
        return $this;
    }
    
}
