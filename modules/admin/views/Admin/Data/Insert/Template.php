<?php
if (!empty($message))
{
    echo AdminHTML::renderMessage($message, $messageType);
}
?>

<div class='well'>
    
    <form class='fieldForm' method="POST" enctype="multipart/form-data">
        <?php
        if (!empty($uploadsDirs))
        {
        ?>
        <div class='col-lg-6'>
            
            <?php
            }
            ?>
            <?php
            foreach ($columns as $columnName => $column)
            {
                ?>
                <div>
                    <h4>
                        <?php echo $column['label'] ?>
                    </h4>
                    
                    <p>
                        <?php echo AdminHTML::renderField(
                            $columnName, $column, isset($post[$columnName])
                            ? $post[$columnName]
                            : null, ['class' => 'form-control']
                        ); ?>
                    </p>
                </div>
                
                <?php
            }
            ?>
            
            <?php
            $href = AdminHREF::getDefaultAdminRouteUri('data', $model->getShortName());
            if (method_exists($model, 'getInsertBackHref'))
            {
                $href = $model->getInsertBackHref();
            }
            ?>
            <a href="<?php echo $href; ?>" class='btn btn-default'>
                <i class="fa fa-mail-reply"></i>
                Вернуться к списку
            </a>
            
            <button type='submit' class='btn btn-warning fieldsSave'>
                <i class="fa fa-floppy-o"></i>
                Добавить
            </button>
            
            <?php
            if (!empty($uploadsDirs))
            {
            ?>
        </div>
        <div class='col-lg-6'>
            
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
                    ?>
                    <div class="form-group">
                        <label><?php echo $directoryIndex; ?></label>
                        <input type='file' name='<?php echo $directoryIndex; ?>[]' multiple="multiple"/>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
    </form>
    
    <div class='clearfix'></div>
</div>

