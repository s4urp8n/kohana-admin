<?php
$filterParams = AdminHREF::getFilterParams();
if (!empty($filterParams))
{
    $filt = array_keys($filterParams);
    foreach ($filt as $key => &$f)
    {
        $f = '<span class="filter_tag">' . $f . '</span>';
    }
    unset($f);
    echo AdminHTML::renderMessage(
        'Задан фильтр по полям: ' . implode(' ', $filt) . '<a href="' . AdminHREF::getNoFilterParamsHREF()
        . '">Сбросить все фильтры</a>', 'info'
    );
}
?>


<?php echo Admin::showMessage(); ?>

<table class="table table-striped table-bordered table-hover">
    
    <?php
    $keys = array_keys($uniqueValues);
    ?>
    
    <?php
    $hiddenColumns = [];
    if (method_exists($model, 'getHiddenColumns'))
    {
        $hiddenColumns = $model->getHiddenColumns();
    }
    ?>
    
    <?php
    $outputFunctions = [];
    if (method_exists($model, 'getOutputFunctions'))
    {
        $outputFunctions = $model->getOutputFunctions();
    }
    ?>
    
    <?php
    $buttons = [];
    if (method_exists($model, 'getActionButtons'))
    {
        $buttons = $model->getActionButtons();
    }
    ?>
    
    <tr>
        
        <?php
        $buttonsCount = count($buttons);
        if ($buttonsCount > 0)
        {
            ?>
            <th colspan="<?php echo $buttonsCount; ?>"></th>
            <?php
        }
        ?>
        
        <?php
        $i = 0;
        foreach ($keys as $value)
        {
            if (!in_array($value, $hiddenColumns))
            {
                ?>
                <th>
                    <?php
                    echo View::factory(
                        'Admin/Data/Filter', [
                                               'key'    => $value,
                                               'values' => $uniqueValues[$value],
                                               'model'  => $model,
                                           ]
                    );
                    ?>
                </th>
                <?php
            }
        }
        ?>
    
    </tr>
    
    <?php
    if (!empty($data))
    {
        ?><?php foreach ($data as $key => $dataArray)
    { ?>
        <tr>
            
            <?php
            foreach ($buttons as $key => $value)
            {
                ?>
                <td style="text-align: center;width:25px;">
                    <?php
                    echo $value($dataArray);
                    ?>
                </td>
                <?php
            }
            ?>
            
            <?php
            foreach ($dataArray as $column => $value)
            {
                if (!in_array($column, $hiddenColumns))
                {
                    ?>
                    <td<?php
                    if ($column == 'id')
                    {
                        echo " style='width:25px;'";
                    }
                    ?>>
                        <div>
                            <?php
                            if (isset($outputFunctions[$column]) && is_callable($outputFunctions[$column]))
                            {
                                echo $outputFunctions[$column]($dataArray);
                            }
                            else
                            {
                                if (mb_strtolower($column) == 'цвет')
                                {
                                    ?>
                                    <span style="background:#<?= $value ?>;width:30px;height:20px;display:inline-block;"></span> <?= $value ?><?php
                                }
                                else
                                {
                                    echo $value;
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <?php
                }
            }
            ?>
        
        </tr>
    <?php } ?><?php
    }
    ?>

</table>