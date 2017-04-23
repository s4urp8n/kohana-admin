<?php
$w = 600;
$h = 400;
$id = '_' . md5(uniqid(md5(rand(0, 1000)), true));
$center = "[55.76, 37.64]";
if (!empty($currentValue)) {
    $center = '[' . $currentValue . ']';
}
?>
<div class='yandexMapPicker'>
    <input name='<?= $fieldName ?>' type='hidden' id='latlong_<?= $id ?>' value='<?= $currentValue ?>'/>
    <div id="<?= $id ?>" style="width: <?= $w ?>px; height: <?= $h ?>px"></div>
</div>
<script type="text/javascript">
    var map<?= $id ?>, placemark<?= $id ?>, searchControl<?= $id ?>;
    ymaps.ready(
        function () {

            searchControl<?= $id ?> = new ymaps.control.SearchControl({
                options: {
                    float: 'left',
                    floatIndex: 100,
                    noPlacemark: true
                }
            });

            map<?= $id ?> = new ymaps.Map("<?= $id ?>", {
                center:<?= $center ?>,
                zoom: 7,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            });

            map<?= $id ?>.controls.add(searchControl<?= $id ?>);

            searchControl<?= $id ?>.events.add([
                'resultshow'
            ], function (e) {
                e.preventDefault();
                e.stopPropagation();
                var coords = searchControl<?= $id ?>.getResultsArray()[e.get('index')].geometry.getCoordinates();
                placemark<?= $id ?>.geometry.setCoordinates(coords);
                $('#latlong_<?= $id ?>').val(coords);
            });

            placemark<?= $id ?> = new ymaps.Placemark(<?= $center ?>, {
                content: '',
                balloonContent: ''
            }, {draggable: true});
            placemark<?= $id ?>.events.add([
                'dragend'
            ], function (e) {
                $('#latlong_<?= $id ?>').val(placemark<?= $id ?>.geometry.getCoordinates());
            });

            map<?= $id ?>.geoObjects.add(placemark<?= $id ?>);

            map<?= $id ?>.events.add('click', function (e) {
                placemark<?= $id ?>.geometry.setCoordinates(e.get('coords'));
                $('#latlong_<?= $id ?>').val(placemark<?= $id ?>.geometry.getCoordinates());
            });

        }
    );
</script>