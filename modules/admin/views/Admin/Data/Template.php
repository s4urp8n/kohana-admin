<form action='<?php echo AdminHREF::getFullHost() . AdminHREF::getPath(); ?>'>
    <?php
    $pagination = '';
    $content = AdminHTML::renderNoneFound();
    $data = $model->getData();
    $uniqueValues = [];
    
    if (!empty($data))
    {
        
        $dataFirstKey = array_keys($data)[0];
        $dataKeys = array_keys($data[$dataFirstKey]);
        
        foreach ($dataKeys as $dataKey)
        {
            $uniqueValues[$dataKey] = Model_Admin::getDistinctSubArrayKeyValues($data, $dataKey);
        }
        
        Model_Admin::filterData($data, $model);
        
        $countData = count($data);
        $perPage = intval(Admin::getConfig('itemsPerPage'));
        $pages = ceil($countData / $perPage);
        $page = AdminHREF::getPage();
        if ($page > $pages)
        {
            $page = $pages;
        }
        
        $content = View::factory(
            'Admin/Data/List', [
                                 'data'         => array_slice($data, ($page - 1) * $perPage, $perPage),
                                 'uniqueValues' => $uniqueValues,
                                 'model'        => $model,
                             ]
        );
        
        $pagination = View::factory(
            'Admin/Data/Pagination', [
                                       'pages'     => $pages,
                                       'page'      => $page,
                                       'countData' => $countData,
                                       'perPage'   => $perPage,
                                   ]
        );
    }
    ?>
    
    <?php echo $pagination, $content, $pagination; ?>

</form>