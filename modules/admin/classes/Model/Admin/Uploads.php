<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin_Uploads extends Model_Admin
{
    
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
        $dir = $this->getUploadDir();
        $dir = array_keys($dir);
        $dir = array_pop($dir);
        
        return AdminHREF::getDefaultAdminRouteUri('dataEdit', $this->getShortName()) . '/' . urlencode($dir) . '/?ref='
               . urlencode(AdminHREF::getFullCurrentHREF());
    }
    
    public function getUploadDir()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }
    
    public function getEditData()
    {
        return [
            'uploadsDirs' => $this->getUploadDir(),
        ];
    }
    
    public function getUploads($key)
    {
        return $this->getModelUploads($this, null, $key);
    }
    
    public function getSharedUploads($key)
    {
        return $this->getSharedModelUploads($this, null, $key);
    }
    
}
