<?php
$groupConfig = Kohana::$config->load('adminMenuGroups')
                              ->as_array();
$groupIcons = [];
foreach ($groupConfig as $value)
{
    if (isset($value['icon']))
    {
        $groupIcons[$value['name']] = $value['icon'];
    }
    else
    {
        $groupIcons[$value['name']] = '';
    }
}
unset($value);
?>

<div>
    <?php
    if (empty($models))
    {
        echo AdminHTML::renderMessage('Не задано ни одной модели', 'warning');
    }
    else
    {
        $groups = array_flip(array_column($groupConfig, 'name'));
        $groups = array_map(
            function ()
            {
                return [];
            }, $groups
        );
        
        $info = null;
        $groupName = null;
        foreach ($models as $modelName => $model)
        {
            $info = $model->getInfo();
            $groupName = $groupConfig[$info['group']]['name'];
            $groups[$groupName][] = $model;
        }
        
        foreach ($groups as &$group)
        {
            Admin::sortModels($group);
        }
        unset($group);
        ?>
        
        <?php
        $groupIcon = '';
        foreach ($groups as $groupName => $group)
        {
            if (!empty($group))
            {
                ?>
                <div class="menuGroup">
                    <h5><?php echo $groupIcons[$groupName]; ?><?php echo $groupName; ?></h5>
                    
                    <div class="list-group">
                        <?php
                        foreach ($group as $model)
                        {
                            ?>
                            <a class='list-group-item' href="<?php echo $model->getHREF(); ?>">
                                <?php echo $model->getCaption(); ?>
                                
                                <?php
                                if (method_exists($model, 'getBadge'))
                                {
                                    echo $model->getBadge();
                                }
                                ?>
                            
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</div>