<div id="<?= $map->getId(); ?>" style="width: <?= $map->getWidth(); ?>; height: <?= $map->getHeight(); ?>">

</div>
<script type="text/javascript">
    ymaps.ready(function () {
        var map = new ymaps.Map("<?= $map->getId() ?>", {
            center: <?= $map->renderCenter() ?>,
            zoom: <?= $map->getZoom() ?>
        });
        
        <?php
        $placemarks = $map->getPlacemarks();
        $placemarksCount = count($placemarks);
        
        if ($placemarksCount > 0) {
        ?>
        var clusterer = new ymaps.Clusterer({
            preset: 'islands#invertedVioletClusterIcons',
            groupByCoordinates: false,
            clusterDisableClickZoom: true,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });
        
        var geoObjects = [];
        
        <?php
        foreach ($placemarks as $index => $placemark) {
        ?>
        geoObjects[<?= $index ?>] = new ymaps.Placemark([<?= $placemark['lt'] ?>, <?= $placemark['lg'] ?>], {
            balloonContentHeader: "<?= $placemark['balloonContentHeader'] ?>",
            balloonContentBody: "<?= $placemark['balloonContentBody'] ?>",
            balloonContentFooter: "<?= $placemark['balloonContentFooter'] ?>",
            hintContent: "<?= $placemark['hintContent'] ?>"
        });
        
        <?php
        }
        ?>
        
        clusterer.add(geoObjects);
        map.geoObjects.add(clusterer);
        
        map.setBounds(clusterer.getBounds(), {
            checkZoomRange: true
        });
        
        <?php
        }
        ?>
    });
</script>