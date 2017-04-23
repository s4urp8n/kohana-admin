<?php

class Yandexmap
{
    
    private static $defaultCenter = [
        'lt' => 55.75,
        'lg' => 37.61,
    ];
    private static $defaultZoom = 10;
    private static $defaultWidth = '600px';
    private static $defaultHeight = '400px';
    private $id = null;
    private $width = null;
    private $height = null;
    private $center = null;
    private $zoom = null;
    private $placemarks = [];
    
    public function __construct()
    {
        $this->id = '_' . md5(uniqid(rand(0, 100), true));
    }
    
    public static function renderStaticMap($lt = null, $lg = null, $zoom = null, $width = null, $height = null)
    {
        if (empty($lt))
        {
            $lt = self::$defaultCenter['lt'];
        }
        if (empty($lg))
        {
            $lg = self::$defaultCenter['lg'];
        }
        if (empty($zoom))
        {
            $zoom = self::$defaultZoom;
        }
        if (empty($width))
        {
            $width = self::$defaultWidth;
        }
        if (empty($height))
        {
            $height = self::$defaultHeight;
        }
        $get = [
            'l'  => 'map',
            'z'  => $zoom,
            'll' => $lg . ',' . $lt,
            'pt' => $lg . ',' . $lt . ',pm2dgl',
        ];
        $src = "http://static-maps.yandex.ru/1.x/?" . http_build_query($get);
        
        return "<img width='" . $width . "'  height='" . $height . "' src='" . $src . "'/>";
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getWidth()
    {
        if (empty($this->width))
        {
            return self::$defaultWidth;
        }
        
        return $this->width;
    }
    
    public function setWidth($width)
    {
        $this->width = $width;
        
        return $this;
    }
    
    public function getHeight()
    {
        if (empty($this->height))
        {
            return self::$defaultHeight;
        }
        
        return $this->height;
    }
    
    public function setHeight($height)
    {
        $this->height = $height;
        
        return $this;
    }
    
    public function getZoom()
    {
        if (empty($this->zoom))
        {
            return self::$defaultZoom;
        }
        
        return $this->zoom;
    }
    
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        
        return $this;
    }
    
    public function renderCenter()
    {
        $center = $this->getCenter();
        
        return '[' . $center['lt'] . ',' . $center['lg'] . ']';
    }
    
    public function getCenter()
    {
        if (empty($this->center))
        {
            return self::$defaultCenter;
        }
        
        return $this->center;
    }
    
    public function setCenter($lt, $lg)
    {
        $this->center = [
            'lt' => $lt,
            'lg' => $lg,
        ];
        
        return $this;
    }
    
    public function getPlacemarks()
    {
        return $this->placemarks;
    }
    
    public function addPlacemarks(
        $lt, $lg, $balloonContentHeader, $balloonContentBody, $balloonContentFooter, $hintContent
    ) {
        $this->placemarks[] = [
            'lt'                   => $lt,
            'lg'                   => $lg,
            'balloonContentHeader' => $balloonContentHeader,
            'balloonContentBody'   => $balloonContentBody,
            'balloonContentFooter' => $balloonContentFooter,
            'hintContent'          => $hintContent,
        ];
        
        return $this;
    }
    
    public function render()
    {
        return View::factory('YandexMap/Map', ['map' => $this]);
    }
    
}
