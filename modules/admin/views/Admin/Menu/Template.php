<nav class="navbar navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <?php
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                ?>
                
                <li<?php echo AdminHREF::isActiveHREF($item['href'])
                    ? ' class="active" '
                    : ''; ?>>
                    <a href="<?php echo $item['href']; ?>"
                        <?php echo (empty($item['target']))
                            ? ''
                            : (' target="' . $item['target'] . '"'); ?>>
                        
                        <?php
                        if (!empty($item['icon']))
                        {
                            echo $item['icon'];
                        }
                        ?>
                        
                        <?php
                        echo $item['caption'];
                        ?>
                    
                    </a>
                </li>
                <?php
            }
        }
        ?>
    
    </ul>
</nav>