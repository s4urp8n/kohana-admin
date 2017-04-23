<?php
$reference = urlencode(
    empty($ref)
        ? AdminHREF::getFullCurrentHREF()
        : $ref
);
?>
<div class="uploadsBlock">
    <?php
    if (!empty($files))
    {
        $charsLimit = 20;
        $deletion = '';
        $croping = '';
        $descriptioning = '';
        $makeFirst = '';
        foreach ($files as $file)
        {
            $descriptioning = Upload::getDescription($file);
            ?>
            <div class='upload'>
                <?php
                $class = 'otherUpload';
                if (Admin::isImageFile($file))
                {
                    $class = 'imageUpload';
                }
                elseif (Admin::isAudioFile($file))
                {
                    $class = 'audioUpload';
                }
                ?>
                
                <?php
                if ($model->isDeletionAllowed())
                {
                    $delHref = AdminHREF::getDefaultAdminRouteUri(
                            'ajaxUploadDelete', $model->getShortName(), $params['primary']
                        ) . '/?directoryIndex=' . urlencode($directoryIndex) . '&file=' . urlencode(basename($file));
                    $deletion = '<button ' . 'type="button" ' . 'class="ajaxUploadsDelete" '
                                . 'confirmText="Вы уверены в удалении?" ' . 'href="' . $delHref . '">'
                                . '<i class="fa fa-trash-o"></i> ' . 'Удалить' . '</button>';
                }
                ?>
                
                <?php
                if ($model->isModifyingAllowed())
                {
                    
                    $descriptioning = View::factory(
                        'Admin/Data/Edit/Upload/descriptionForm', [
                                                                    'file'      => $file,
                                                                    'reference' => $reference,
                                                                    'modelName' => $model->getShortName(),
                                                                ]
                    );
                    
                    $makeFirst = View::factory(
                        'Admin/Data/Edit/Upload/makeFirstForm', [
                                                                  'reference' => $reference,
                                                                  'file'      => $file,
                                                                  'modelName' => $model->getShortName(),
                                                              ]
                    );
                    
                }
                ?>
                
                <?php
                $iconFile = Admin::getFileExtension($file) . '.png';
                $iconPath =
                    Admin::getConfig('sharedDir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'exts'
                    . DIRECTORY_SEPARATOR;
                if (!file_exists(DOCROOT . $iconPath . $iconFile))
                {
                    $iconFile = 'file.png';
                }
                
                $icon = '/' . mb_eregi_replace('\\\\', '/', $iconPath . $iconFile);
                ?>
                
                <a target='blank'
                   title='<?php echo basename($file); ?>'
                   class='<?php echo $class; ?>'
                   href="<?php echo $file; ?>">
                    
                    <?php
                    if ($class == 'imageUpload')
                    {
                        ?>
                        <div class="preview" style='background-image:url("<?php echo $file; ?>");'></div>
                        <?php
                    }
                    elseif ($class == 'audioUpload')
                    {
                        ?>
                        <div class="preview" style='background-image:url("<?php echo $icon; ?>");'>
                            <audio controls>
                                <source src="<?php echo $file; ?>"/>
                            </audio>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="preview" style='background-image:url("<?php echo $icon; ?>");'></div>
                        <?php
                    }
                    ?>
                    
                    <span class="caption"><?php echo Text::limit_chars(
                            mb_substr(basename($file), 0, -1 - mb_strlen(Admin::getFileExtension($file))), $charsLimit,
                            '...'
                        ); ?></span>
                
                </a>
                <?php echo $descriptioning; ?>
                <?php echo $makeFirst; ?>
                <?php echo $croping; ?>
                <?php echo $deletion; ?>
            </div>
            
            <?php
        }
        ?><?php
    }
    ?>
</div>
