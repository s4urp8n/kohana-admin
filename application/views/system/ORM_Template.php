<?= '<?php' ?>

class Model_<?= \Zver\StringHelper::load($table)
                        ->toLowerCase()
                        ->toUpperCaseFirst()
                        ->get() ?> extends ORM
{

protected $_table_name = '<?= \Zver\StringHelper::load($table)
                                      ->toLowerCase()
                                      ->get() ?>';
    
}
