<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin_Order extends Model_Admin
{
    
    public function getOrderData()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }
    
    public function getDeletionRoles()
    {
        return $this->getAllowedRoles();
    }
    
    public function getModifyingRoles()
    {
        return $this->getAllowedRoles();
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('dataOrder', $this->getShortName());
    }
    
}
