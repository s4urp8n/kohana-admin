<?= '<?php' ?>

class Model_<?= \Str\Str::load($table)
                        ->toLowerCase()
                        ->toUpperCaseFirst()
                        ->get() ?> extends ORM
{

protected $_table_name = '<?= \Str\Str::load($table)
                                      ->toLowerCase()
                                      ->get() ?>';
    
}
