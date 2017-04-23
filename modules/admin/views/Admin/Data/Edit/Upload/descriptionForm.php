<form action='/admin/uploadDescription/<?= $modelName ?>?ref=<?= $reference ?>' method='POST'>
    <textarea class='desctext' rows='5' name='description'><?= Upload::getDescription($file); ?></textarea>
    <input type='hidden' name='file' value='<?= $file; ?>'/>
    <button type='submit' class="cropLink">
        <i class="fa fa-pencil"></i>
        Сохранить описание
    </button>
</form>