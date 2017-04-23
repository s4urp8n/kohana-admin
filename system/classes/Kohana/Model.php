<?php

defined('SYSPATH') OR die('No direct script access.');

/**
 * Model base class. All models should extend this class.
 *
 * @package        Kohana
 * @category       Models
 * @author         Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license        http://kohanaframework.org/license
 */
abstract class Kohana_Model
{
    
    protected $additionalData = [];
    
    /**
     * Create a new model instance.
     *
     *     $model = Model::factory($name);
     *
     * @param   string $name model name
     *
     * @return  Model
     */
    public static function factory($name)
    {
        // Add the model prefix
        $class = 'Model_' . $name;
        
        return new $class;
    }
    
    public function getAdditionalData($key)
    {
        if (array_key_exists($key, $this->additionalData))
        {
            return $this->additionalData[$key];
        }
        
        return null;
    }
    
    public function setAdditionalData($key, $value)
    {
        $this->additionalData[$key] = $value;
    }
}
