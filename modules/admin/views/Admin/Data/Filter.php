<?php

$unfiltered = [];
if (method_exists($model, 'getUnfilteredColumns'))
{
    $unfiltered = $model->getUnfilteredColumns();
}

if (in_array($key, $unfiltered) || count($values) < 2)
{
    echo $key;
}
else
{
    $prefix = Admin::getConfig('filterQueryPrefix');
    
    $values = array_unique($values);
    natcasesort($values);
    $values = array_combine(array_values($values), $values);
    $selected = null;
    
    $filterParams = AdminHREF::getFilterParams();
    
    if (isset($filterParams[$key]))
    {
        $selected = $filterParams[$key];
    }
    
    $attrs = [
        'multiple'    => 'multiple',
        'class'       => 'sumoselect',
        'placeholder' => $key,
    ];
    
    echo Form::select($prefix . AdminHREF::$prefixSeparator . $key . '[]', $values, $selected, $attrs);
}
