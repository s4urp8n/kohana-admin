<form method="POST" class='fieldForm'>
    <?php
    foreach ($data as $key => $value)
    {
        ?>
        <div>
            <h4>
                <?php echo empty($columns[$key]['label'])
                    ? $key
                    : $columns[$key]['label'] ?>
            </h4>
            <p>
                <?php echo AdminHTML::renderField($key, $columns[$key], $value, ['class' => 'form-control']); ?>
            </p>
        </div>
        
        <?php
    }
    ?>
    <?php
    foreach ($columns as $key => $value)
    {
        if (!empty($columns[$key]['dont_select']))
        {
            ?>
            <div>
                <h4>
                    <?php echo empty($columns[$key]['label'])
                        ? $key
                        : $columns[$key]['label'] ?>
                </h4>
                <p>
                    <?php echo AdminHTML::renderField(
                        $key, $columns[$key], $columns[$key]['get_current_value'](), ['class' => 'form-control']
                    ); ?>
                </p>
            </div>
            
            <?php
        }
    }
    ?>
    
    <div class="edit-form-buttons">
        <a href="<?php echo $query['ref']; ?>" class='btn btn-default'>
            <i class="fa fa-mail-reply"></i>
            Вернуться к списку
        </a>
        
        <button type='submit' class='fieldsSave btn btn-warning'>
            <i class="fa fa-floppy-o"></i>
            Сохранить изменения
        </button>
    
    </div>

</form>