<?php
if (!empty($caption))
{
    ?>
    <div class="captionDiv">
        <h4><?php echo $caption; ?></h4>
    </div>
    <?php
}
?>

<div class="list-group">
    <?php
    foreach ($values as $key => $value)
    {
        ?>
        <a class='list-group-item' href='<?php echo AdminHREF::getFullCurrentHREF() . '/' . $key; ?>'>
            <?php echo $value; ?>
        </a>
        <?php
    }
    ?>
</div>