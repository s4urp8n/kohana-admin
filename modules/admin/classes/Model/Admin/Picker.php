<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin_Picker extends Model_Admin
{
    
    public static $separator = '___--==--=wd3423454354645567676756sdmfsdfmfsdmfe=--==----============____';
    
    public function savePicks()
    {
        if (!empty($_POST))
        {
            $reset = [];
            foreach ($_POST as $name => $picked)
            {
                list($id, $model) = explode(self::$separator, $name);
                if (!in_array($model, $reset))
                {
                    $entities = new $model();
                    $entities = $entities->find_all();
                    
                    foreach ($entities as $entity)
                    {
                        $entity->picked = 0;
                        $entity->save();
                    }
                    $reset[] = $model;
                }
                $entity = new $model($id);
                $entity->picked = 1;
                $entity->save();
            }
        }
    }
    
    public function getPickData()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('picker', $this->getShortName());
    }
    
    public function getAllowedRoles()
    {
        return ['admin'];
    }
    
    public function getDeletionRoles()
    {
        return $this->getAllowedRoles();
    }
    
    public function getModifyingRoles()
    {
        return $this->getAllowedRoles();
    }
    
}
