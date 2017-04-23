<?php
$uploads = false;
$fields = false;

$editData = $model->getEditData($params['primary']);

$uploadsDirs = null;
if (!empty($editData['uploadsDirs']))
{
    $uploadsDirs = $editData['uploadsDirs'];
    $uploads = true;
}

if (!empty($editData['tableName']))
{
    
    $fields = true;
    $message = null;
    $messageType = 'success';
    
    $table = $editData['tableName'];
    $primaryColumn = $editData['primary'];
    $columns = $editData['columns'];
    
    $validate = null;
    if (!empty($editData['validate']) && is_callable($editData['validate']))
    {
        $validate = $editData['validate'];
    }
    
    $update = function ($table, $post, $primaryColumn, $primary)
    {
        DB::update($table)
          ->set($post)
          ->where($primaryColumn, '=', $primary)
          ->execute();
    };
    
    if (!empty($editData['update']) && is_callable($editData['update']))
    {
        $update = $editData['update'];
    }
    
    $post = [];
    if (!empty($_POST))
    {
        $message = 'Изменения успешно внесены';
        $post = $_POST;
        
        if (isset($post['files']))
        {
            unset($post['files']);
        }
        
        $valid = false;
        if (is_null($validate))
        {
            $valid = true;
        }
        else
        {
            $validation = $validate($post);
            if ($validation === true)
            {
                $valid = true;
            }
            else
            {
                $message = $validation;
                $messageType = 'warning';
            }
        }
        
        if ($valid)
        {
            try
            {
                $update($table, $post, $primaryColumn, $params['primary']);
            }
            catch (Database_Exception $e)
            {
                $message = 'При внесении изменений произошла ошибка:<br/><br/>' . $e->getMessage()
                           . "<br/><br/>Исправьте ошибку и повторите попытку или обратитесь к администратору";
                $messageType = 'danger';
            }
        }
    }
    
    $data = DB::select();
    
    foreach ($columns as $column => $columnData)
    {
        if (empty($columnData['dont_select']))
        {
            $data->select($column);
        }
    }
    
    $data = $data->from($table)
                 ->where($primaryColumn, '=', $params['primary'])
                 ->execute()
                 ->current();
    ?>
    
    <?php
    echo Admin::showMessage();
    ?>
    
    <?php
    if (!empty($message))
    {
        echo AdminHTML::renderMessage($message, $messageType);
    }
    ?>
    
    <?php
}
?>

<div class='well'>
    
    <?php
    $subWellClass = '';
    
    if ($uploads === true && $fields == true)
    {
        $subWellClass = ' class="col-lg-6"';
    }
    ?>
    
    <?php if ($fields === true)
    { ?>
        <div<?php echo $subWellClass; ?>>
            
            <?php
            echo View::factory(
                'Admin/Data/Edit/Fields', [
                                            'data'    => $data,
                                            'columns' => $columns,
                                            'query'   => $query,
                                        ]
            );
            ?>
        
        </div>
    <?php } ?>
    
    <?php if ($uploads === true)
    { ?>
        <div<?php echo $subWellClass; ?>>
            <?php
            
            if (method_exists($model, 'getUploadsText'))
            {
                ?>
                <div class="alert alert-warning">
                    <?= $model->getUploadsText() ?>
                </div>
                <?php
            }
            
            ?>
            
            <div class="<?= method_exists($model, 'getUploadsClass')
                ? $model->getUploadsClass()
                : '' ?>">
                <?php
                foreach ($uploadsDirs as $directoryIndex => $dir)
                {
                    echo View::factory(
                        'Admin/Data/Edit/Upload/Template', [
                                                             'directoryIndex' => $directoryIndex,
                                                             'model'          => $model,
                                                             'params'         => $params,
                                                             'query'          => $query,
                                                         ]
                    );
                }
                ?>
            </div>
        </div>
    <?php } ?>
    
    <div class='clearfix'></div>
</div>

