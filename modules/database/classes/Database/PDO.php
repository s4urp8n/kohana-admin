<?php

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Override PDO so that PDO MySQL will support list_tables
 * and list_columns and bottom line, ORM will work with PDO MySQL
 *
 */
class Database_PDO extends Kohana_Database_PDO
{
    
    public function list_tables($like = null)
    {
        if (is_string($like))
        {
            // Search for table names
            $result = $this->query(Database::SELECT, 'SHOW TABLES LIKE ' . $this->quote($like), false);
        }
        else
        {
            // Find all table names
            $result = $this->query(Database::SELECT, 'SHOW TABLES', false);
        }
        
        $tables = [];
        foreach ($result as $row)
        {
            $tables[] = reset($row);
        }
        
        return $tables;
    }
    
    public function list_columns($table, $like = null, $add_prefix = true)
    {
        // Quote the table name
        $table = ($add_prefix === true)
            ? $this->quote_table($table)
            : $table;
        
        if (is_string($like))
        {
            // Search for column names
            $result = $this->query(
                Database::SELECT, 'SHOW FULL COLUMNS FROM ' . $table . ' LIKE ' . $this->quote($like), false
            );
        }
        else
        {
            // Find all column names
            $result = $this->query(Database::SELECT, 'SHOW FULL COLUMNS FROM ' . $table, false);
        }
        
        $count = 0;
        $columns = [];
        foreach ($result as $row)
        {
            list($type, $length) = $this->_parse_type($row['Type']);
            
            $column = $this->mysql_datatype($type);
            
            $column['column_name'] = $row['Field'];
            $column['column_default'] = $row['Default'];
            $column['data_type'] = $type;
            $column['is_nullable'] = ($row['Null'] == 'YES');
            $column['ordinal_position'] = ++$count;
            
            switch ($column['type'])
            {
                case 'float':
                    if (isset($length))
                    {
                        list($column['numeric_precision'], $column['numeric_scale']) = explode(',', $length);
                    }
                    break;
                case 'int':
                    if (isset($length))
                    {
                        // MySQL attribute
                        $column['display'] = $length;
                    }
                    break;
                case 'string':
                    switch ($column['data_type'])
                    {
                        case 'binary':
                        case 'varbinary':
                            $column['character_maximum_length'] = $length;
                            break;
                        case 'char':
                        case 'varchar':
                            $column['character_maximum_length'] = $length;
                        case 'text':
                        case 'tinytext':
                        case 'mediumtext':
                        case 'longtext':
                            $column['collation_name'] = $row['Collation'];
                            break;
                        case 'enum':
                        case 'set':
                            $column['collation_name'] = $row['Collation'];
                            $column['options'] = explode('\',\'', substr($length, 1, -1));
                            break;
                    }
                    break;
            }
            
            // MySQL attributes
            $column['comment'] = $row['Comment'];
            $column['extra'] = $row['Extra'];
            $column['key'] = $row['Key'];
            $column['privileges'] = $row['Privileges'];
            
            $columns[$row['Field']] = $column;
        }
        
        return $columns;
    }
    
    public function mysql_datatype($type)
    {
        static $types = [
            'blob'                      => [
                'type'                     => 'string',
                'binary'                   => true,
                'character_maximum_length' => '65535',
            ],
            'bool'                      => ['type' => 'bool'],
            'bigint unsigned'           => ['type' => 'int', 'min' => '0', 'max' => '18446744073709551615'],
            'datetime'                  => ['type' => 'string'],
            'decimal unsigned'          => ['type' => 'float', 'exact' => true, 'min' => '0'],
            'double'                    => ['type' => 'float'],
            'double precision unsigned' => ['type' => 'float', 'min' => '0'],
            'double unsigned'           => ['type' => 'float', 'min' => '0'],
            'enum'                      => ['type' => 'string'],
            'fixed'                     => ['type' => 'float', 'exact' => true],
            'fixed unsigned'            => ['type' => 'float', 'exact' => true, 'min' => '0'],
            'float unsigned'            => ['type' => 'float', 'min' => '0'],
            'int unsigned'              => ['type' => 'int', 'min' => '0', 'max' => '4294967295'],
            'integer unsigned'          => ['type' => 'int', 'min' => '0', 'max' => '4294967295'],
            'longblob'                  => [
                'type'                     => 'string',
                'binary'                   => true,
                'character_maximum_length' => '4294967295',
            ],
            'longtext'                  => ['type' => 'string', 'character_maximum_length' => '4294967295'],
            'mediumblob'                => [
                'type'                     => 'string',
                'binary'                   => true,
                'character_maximum_length' => '16777215',
            ],
            'mediumint'                 => ['type' => 'int', 'min' => '-8388608', 'max' => '8388607'],
            'mediumint unsigned'        => ['type' => 'int', 'min' => '0', 'max' => '16777215'],
            'mediumtext'                => ['type' => 'string', 'character_maximum_length' => '16777215'],
            'national varchar'          => ['type' => 'string'],
            'numeric unsigned'          => ['type' => 'float', 'exact' => true, 'min' => '0'],
            'nvarchar'                  => ['type' => 'string'],
            'point'                     => ['type' => 'string', 'binary' => true],
            'real unsigned'             => ['type' => 'float', 'min' => '0'],
            'set'                       => ['type' => 'string'],
            'smallint unsigned'         => ['type' => 'int', 'min' => '0', 'max' => '65535'],
            'text'                      => ['type' => 'string', 'character_maximum_length' => '65535'],
            'tinyblob'                  => ['type' => 'string', 'binary' => true, 'character_maximum_length' => '255'],
            'tinyint'                   => ['type' => 'int', 'min' => '-128', 'max' => '127'],
            'tinyint unsigned'          => ['type' => 'int', 'min' => '0', 'max' => '255'],
            'tinytext'                  => ['type' => 'string', 'character_maximum_length' => '255'],
            'year'                      => ['type' => 'string'],
        ];
        
        $type = str_replace(' zerofill', '', $type);
        
        if (isset($types[$type]))
        {
            return $types[$type];
        }
        
        return $this->datatype($type);
    }
    
}
