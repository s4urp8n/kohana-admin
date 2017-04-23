<form action='' method='post'>
    
    <div>
        
        <?php
        $id = '';
        foreach ($data as $entity)
        {
            $id = md5(uniqid('', true));
            ?>
            <label for="<?= $id ?>" class='pickerItem'>
                <?php
                if (method_exists($entity, 'getImage'))
                {
                    $image = $entity->getImage();
                    if (!empty($image))
                    {
                        ?>
                        <img src='<?= ImagePreview::getPreview($image, 200, 150) ?>'>
                        <?php
                    }
                }
                ?>
                <input id='<?= $id ?>'
                       type="checkbox"
                       name='<?= implode(Model_Admin_Picker::$separator, [$entity->id, get_class($entity)]) ?>'
                    <?php
                    if ($entity->picked == 1)
                    {
                        ?>
                        checked
                        <?php
                    }
                    ?>
                />
                <?= $entity->name ?>
            </label>
            <?php
        }
        ?>
    </div>
    
    <a href="/admin/menu" class="btn btn-default">
        <i class="fa fa-mail-reply"></i>
        Вернуться к меню
    </a>
    
    <button type='submit' class='btn btn-warning'>
        <i class="fa fa-floppy-o"></i>
        Сохранить
    </button>

</form>