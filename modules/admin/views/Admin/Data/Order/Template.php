<form action='' method='post'>
    <div class="sortable">
        <?php
        foreach ($values as $value)
        {
            ?>
            <p>
                <i class='fa fa-sort'></i> <?php echo $value['caption']; ?>
                <input type="hidden" name='primaries[]' value='<?php echo $value['primary']; ?>'/>
                <input type="hidden" class='sort-number' name='numbers[]' value='<?php echo $value['number']; ?>'/>
            </p>
            <?php
        }
        ?>
    
    </div>
    
    <div class="edit-form-buttons">
        
        <?php
        if (!empty($ref))
        {
            ?>
            <a href="<?php echo $ref; ?>" class="btn btn-default">
                <i class="fa fa-mail-reply"></i>
                Вернуться к списку
            </a>
            <?php
        }
        ?>
        
        <button type='submit' class='btn btn-warning'>
            <i class="fa fa-floppy-o"></i>
            Сохранить порядок
        </button>
        
        <button type='submit' name='reset' value='reset' class='btn btn-default'>
            <i class="fa fa-trash-o"></i>
            Сброс порядка
        </button>
    </div>

</form>