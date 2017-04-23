<?php

class Cart
{
    
    /**
     * Cookie key name, default null.
     *
     * @var null
     */
    private static $_key = null;
    
    /**
     * Clear cart.
     *
     * @throws Exception
     */
    public static function clear()
    {
        self::set([]);
    }
    
    /**
     * Set cart value.
     *
     * @param mixed $value Value to set to
     *
     * @throws \Exception
     */
    public static function set($value)
    {
        $set = Session::instance()
                      ->set(self::getKey(), $value);
    }
    
    /**
     * Generate key from hostname with salt.
     *
     * @return string
     */
    private static function getKey()
    {
        if (is_null(self::$_key))
        {
            $key = 'fk34hwefjwf7823sdfkewvm349f3h4fdsvifj239fdj';
            try
            {
                $key = '_' . md5(shell_exec('hostname') . $key);
            }
            catch (\Exception $e)
            {
                
            }
            self::$_key = $key;
        }
        
        return self::$_key;
    }
    
    /**
     * Add item to cart.
     *
     * @param integer $id     Identificator of added item
     * @param mixed   $values Optional params array
     *
     * @throws \Exception
     */
    public static function add($id, $values = null)
    {
        $cart = self::get();
        $cart[$id] = $values;
        self::set($cart);
    }
    
    /**
     * Get array of cart items.
     *
     * @return array Array of cart items
     */
    public static function get()
    {
        
        $cart = Session::instance()
                       ->get(self::getKey(), []);
        
        if (is_null($cart) || !is_array($cart))
        {
            return [];
        }
        
        return $cart;
        
    }
    
    /**
     * Remove item with identificator $id from cart.
     *
     * @param integer $id Item identificator
     *
     * @throws \Exception
     */
    public static function remove($id)
    {
        $cart = self::get();
        if (self::in($id))
        {
            unset($cart[$id]);
            self::set($cart);
        }
    }
    
    /**
     * Return true if cart contains item with identificator equals $id.
     *
     * @param integer $id
     *
     * @return bool
     */
    public static function in($id)
    {
        $cart = self::get();
        if (isset($cart[$id]))
        {
            return true;
        }
        
        return false;
    }
    
    public static function getCount()
    {
        return count(self::get());
    }
    
}