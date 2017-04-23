<?php
$request = Request::initial();
$original = $request->query('file');
$originalFull = mb_substr(DOCROOT, 0, -1) . $original;

$previews = ImagePreview::findPreviews($originalFull);
$previewsShared = $previews;

foreach ($previewsShared as $key => $shared)
{
    $previewsShared[$key]['previewFile'] = mb_substr($shared['previewFile'], mb_strlen(DOCROOT) - 1);
}
?>

<div class='well'>
    
    <form action='' method='POST'>
        <div>
            <a href="<?php echo $request->query('ref'); ?>" class="btn btn-default">
                <i class="fa fa-mail-reply"></i>
                Вернуться к списку
            </a>
            
            <button id='cropSave' type="submit" class="fieldsSave btn btn-warning">
                <i class="fa fa-floppy-o"></i>
                Сохранить изменения
            </button>
        </div>
        <br/>
        <div class='alert alert-info'>
            Для изменения кликните на изображение.
            <br/>
            Не торопитесь, если изображение большое - процесс не будет выполняться мгновенно.
            <br/>
            Миниатюры становятся доступными для редактирования только после того, как они были просмотрены на странице
            сайта.
        </div>
        
        <div class='cropDiv'>
            <?php
            $id = '';
            foreach ($previewsShared as $shared)
            {
                $id = md5(uniqid(rand(132, 12121212), true));
                ?>
                <img class='firstly'
                     id='<?= $id ?>'
                     src="<?= $shared['previewFile'] . '?rrwe=' . rand() ?>"
                     preview="<?= $shared['previewFile'] ?>"
                     cwidth="<?= $shared['width'] ?>"
                     cheight="<?= $shared['height'] ?>"/>
                <input type='hidden' id='input_<?= $id ?>' name='<?= $shared['previewFile'] ?>'/>
                <?php
            }
            ?>
        </div>
    
    </form>

</div>
<script>
    $(document).ready(function () {
        
        var original = "<?= $original ?>";
        
        $("body").on("click", ".cropDiv img.firstly", function (event) {
            var image = $(this);
            image.attr('src', original);
            image.removeClass('firstly');
            image.cropbox({
                              label: '',
                              showControls: 'always',
                              width: image.attr('cwidth'),
                              height: image.attr('cheight')
                          }).on('cropbox', function (e, results, img) {
                var url = img.getDataURL();
                var id = $(event.target).attr('id');
                $('#input_' + id.toString()).val(url);
            });
        });
        
        $('#cropSave').click(function () {
            $(this).parent().parent().submit();
        });
    });
</script>