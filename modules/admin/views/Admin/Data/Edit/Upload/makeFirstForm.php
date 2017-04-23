<form action='/admin/uploadMakeFirst/<?= $modelName ?>?ref=<?= $reference ?>' method='POST'>
    <input type='hidden' name='file' value='<?= $file; ?>'/>
    <button type='submit' class="cropLink">Сделать первым</button>
</form>