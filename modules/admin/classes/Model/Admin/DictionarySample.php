<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin_DictionarySample extends Model_Admin
{
    
    public static $tableName = "";
    
    public static $modelLabel = "";
    public static $valueLabel = "";
    
    public static $icon = "";
    public static $group = "";
    
    public function getInfo()
    {
        return [
            'caption' => static::$modelLabel,
            'icon'    => '<i class="fa ' . static::$icon . '"></i>',
            'group'   => static::$group,
        ];
    }
    
    public function getHREF()
    {
        return AdminHREF::getDefaultAdminRouteUri('data', $this->getShortName());
    }
    
    public function getInsertColumns()
    {
        $process = static::processValue();
        
        return [
            'validate'  => $this->getValidatePost(),
            'tableName' => static::$tableName,
            'columns'   => static::getCommonColumns(),
            'insert'    => function ($table, $post) use ($process)
            {
                $name = $process($post['name']);
                $sha1 = sha1($name);
                $sql = "INSERT IGNORE INTO " . $table . " VALUES (NULL, :name, :sha1name, :description, :visible)";
                $insert = DB::query(Database::INSERT, $sql)
                            ->bind(':name', $name)
                            ->bind(':sha1name', $sha1)
                            ->bind(':description', $post['description'])
                            ->bind(':visible', $post['visible'])
                            ->execute();
                
                return $insert;
            },
        ];
    }
    
    public static function processValue()
    {
        return function ($value)
        {
            return $value;
        };
    }
    
    public function getValidatePost()
    {
        return function ($post)
        {
            if (empty($post['name']))
            {
                return 'Поле "' . static::$valueLabel . '" не должно быть пустым';
            }
            
            return true;
        };
    }
    
    public static function getCommonColumns()
    {
        return [
            'name'        => [
                'label' => static::$valueLabel,
                'type'  => 'text',
            ],
            'description' => [
                'label' => 'Описание',
                'type'  => 'textarea',
            ],
            'visible'     => [
                'label' => 'Видимость',
                'type'  => 'bool',
            ],
        ];
    }
    
    public function getEditData($primary)
    {
        $process = static::processValue();
        
        return [
            'validate'  => $this->getValidatePost(),
            'tableName' => static::$tableName,
            'primary'   => 'id',
            'columns'   => static::getCommonColumns(),
            'update'    => function ($table, $post, $primaryColumn, $primary) use ($process)
            {
                $name = $process($post['name']);
                $sha1 = sha1($name);
                $sql = "UPDATE " . $table
                       . " SET name=:name, sha1name=:sha1name, description=:description, visible=:visible WHERE :primaryColumn=:primary";
                $update = DB::query(Database::UPDATE, $sql)
                            ->bind(':name', $name)
                            ->bind(':sha1name', $sha1)
                            ->bind(':description', $post['description'])
                            ->bind(':visible', $post['visible'])
                            ->bind(':primaryColumn', $primaryColumn)
                            ->bind(':primary', $primary)
                            ->execute();
                
                return $update;
            },
        ];
    }
    
    public function deleteData($id = null)
    {
        DB::delete(static::$tableName)
          ->where('id', '=', $id)
          ->execute();
    }
    
    public function getData()
    {
        
        $createIfNotExists = '
          CREATE TABLE IF NOT EXISTS `' . static::$tableName . '`
            (
                `id` INT NOT NULL AUTO_INCREMENT ,
                `name` LONGTEXT NOT NULL,
                `sha1name` VARCHAR(160) NOT NULL,
                `description` LONGTEXT NULL ,
                `visible` INT(3) NOT NULL DEFAULT \'0\' ,
                PRIMARY KEY (`id`),
                INDEX (`visible`),
                UNIQUE (`sha1name`)
            )
          ';
        
        DB::query(Database::INSERT, $createIfNotExists)
          ->execute();
        
        $data = DB::select('id')
                  ->from(static::$tableName)
                  ->order_by('name', 'asc')
                  ->order_by('visible', 'desc');
        
        foreach (static::getCommonColumns() as $columnName => $columnData)
        {
            $data->select([$columnName, $columnData['label']]);
        }
        
        return $data->execute()
                    ->as_array();
    }
    
}
