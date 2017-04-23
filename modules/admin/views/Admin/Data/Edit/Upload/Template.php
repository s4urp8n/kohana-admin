<div class="uploadsContainer">
    
    <?php
    $uid = '_' . mb_eregi_replace('\.', '', uniqid('', true) . uniqid('', true) . uniqid('', true));
    ?>
    <h4><?php echo $directoryIndex; ?></h4>
    
    <div id="<?php echo $uid; ?>">Загрузить</div>
    
    <script>
        $(document).ready(function () {
            var <?php echo $uid; ?>_loading = '<div id="<?php echo $uid; ?>_load" \n\
                style="position:fixed;top:30%;left:0;display:block;width:100%;background:none;text-align:center;">\n\
                    <div style="box-shadow:0 0 10px #bbb;background:#fff;display:inline-block;width:80px;height:80px;padding-top:5px;border-radius:20px;">\n\
                        <i style="color:#2f8ab9;" class="fa fa-cog fa-spin fa-3x"></i>\n\
                        <p style="font-weight:bold;color:#2f8ab9;">Загрузка</p>\n\
                    </div>\n\
                </div>';
            $("#<?php echo $uid; ?>").uploadFile({
                                                     url: "<?php echo AdminHREF::getDefaultAdminRouteUri(
                                                         'ajaxUpload', $model->getShortName(), $params['primary']
                                                     ); ?>/?directoryIndex=<?php echo urlencode($directoryIndex); ?>",
                                                     fileName: "file",
                                                     multiple: true,
                                                     showDone: false,
                                                     showCancel: false,
                                                     showAbort: false,
                                                     showDelete: false,
                                                     showProgress: false,
                                                     showFileCounter: false,
                                                     showStatusAfterSuccess: false,
                                                     dragDropStr: '',
                                                     autoSubmit: true,
                                                     onSubmit: function (files) {
                                                         if ($('#<?php echo $uid; ?>_load').length == 0) {
                                                             $('body').append(<?php echo $uid; ?>_loading);
                                                         }
                                                     },
                                                     onError: function (files, status, errMsg) {
                                                         $('#<?php echo $uid; ?>_load').remove();
                                                     },
                                                     afterUploadAll: function () {
                                                         $('#<?php echo $uid; ?>_load').remove();
                                                         var url = "<?php echo AdminHREF::getDefaultAdminRouteUri(
                                                                 'ajaxUploadsContent', $model->getShortName(),
                                                                 $params['primary']
                                                             ) . '/?directoryIndex=' . urlencode($directoryIndex); ?>";
                                                         $.post(url, {ref: document.location.href}, function (data) {
                                                             $('#<?php echo $uid; ?>_content').children().replaceWith(data);
                                                         });
                                                     },
                                                 });
        });
    </script>
    <div id="<?php echo $uid; ?>_content">
        <?php
        echo View::factory(
            'Admin/Data/Edit/Upload/List', [
                                             'files'          => Model_Admin::getSharedModelUploads(
                                                 $model, $params['primary'], $directoryIndex
                                             ),
                                             'model'          => $model,
                                             'params'         => $params,
                                             'query'          => $query,
                                             'directoryIndex' => $directoryIndex,
                                         ]
        );
        ?>
    </div>
</div>