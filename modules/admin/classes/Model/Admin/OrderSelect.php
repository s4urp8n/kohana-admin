<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin_OrderSelect extends Model_Admin_Order
{
    
    public function getOrderSelectData()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('dataOrderSelect', $this->getShortName());
    }
    
}
