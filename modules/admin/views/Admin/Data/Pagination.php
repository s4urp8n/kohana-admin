<?php
$spaces = intval(Admin::getConfig('paginationLinksCount'));
if (!is_numeric($spaces) || $spaces < 2)
{
    $spaces = 2;
}

if ($spaces % 2 !== 0)
{
    ++$spaces;
}

$getParam = Admin::getConfig('pageQueryParam');
?>

<nav class="navbar navbar-default adminPagination" role="navigation">
    <ul class="nav navbar-nav">
        <li>
            <?php
            $countCaption = '';
            
            if ($countData > 0)
            {
                
                $countCaption = 'Объектов: ' . $countData;
                
                if ($pages > 1)
                {
                    $countCaption = $countCaption . ', страниц: ' . $pages;
                }
            }
            else
            {
                $countCaption = 'Объектов не найдено';
            }
            ?>
            <a><?php echo $countCaption; ?></a>
        </li>
        <?php
        if ($pages > 1)
        {
            ?><?php
            $half = $spaces / 2;
            $toRender = [$page];
            if ($pages <= $spaces)
            {
                //no pages overflow
                $toRender = range(1, $pages);
            }
            else
            {
                if ($page - $half <= 0)
                {
                    //overflow begin
                    if ($page > 1)
                    {
                        $toRender = array_merge(range(1, $page - 1), $toRender);
                    }
                    $toRender = array_merge($toRender, range($page + 1, $page + $spaces - count($toRender) + 1));
                }
                elseif ($page + $half > $pages)
                {
                    //overflow end
                    if ($page < $pages)
                    {
                        $toRender = array_merge($toRender, range($page + 1, $pages));
                    }
                    $toRender = array_merge(range($page - ($spaces - count($toRender)) - 1, $page - 1), $toRender);
                }
                else
                {
                    //not overflow
                    $toRender =
                        array_merge(range($page - $half, $page - 1), $toRender, range($page + 1, $page + $half));
                }
            }
            ?>
            
            <?php if ($pages > $spaces)
        { ?>
            
            <?php
            //first page
            $href = AdminHREF::getFullCurrentHREF([], [$getParam => 1]);
            ?>
            <li<?php echo AdminHREF::isActiveHREF($href, $page == 1)
                ? ' class="active" '
                : ''; ?>>
                <a href="<?php echo $href; ?>">&larr; Первая</a>
            </li>
            <?php ?>
        
        <?php } ?>
            
            <?php
            //all numeric pages
            foreach ($toRender as $i)
            {
                $href = AdminHREF::getFullCurrentHREF([], [$getParam => $i]);
                ?>
                <li<?php echo AdminHREF::isActiveHREF($href, $page == $i)
                    ? ' class="active" '
                    : ''; ?>>
                    <a href="<?php echo $href; ?>"><?php echo $i; ?></a>
                </li>
                <?php
            }
            ?>
            
            <?php if ($pages > $spaces)
        { ?>
            
            <?php
            //last page
            $href = AdminHREF::getFullCurrentHREF([], [$getParam => $pages]);
            ?>
            <li<?php echo AdminHREF::isActiveHREF($href, $page == $pages)
                ? ' class="active" '
                : ''; ?>>
                <a href="<?php echo $href; ?>">Последняя &rarr;</a>
            </li>
        
        <?php } ?>
            
            <?php
        }
        ?>
    </ul>
</nav>