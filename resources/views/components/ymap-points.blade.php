<script>
    function toggle() {
        if ($('#checkbox').prop('checked')) {
            $('#map').show();
        } else {
            $('#map').hide();
            $('#coords').val('');
        }
    }

    $(function () {
        ymaps.ready(init);
        window.ready = ($('#checkbox').prop('checked', false));
    });

    function init() {
        let myMap = new ymaps.Map("map", {
            center: [62.358, 50.072],
            zoom: 13
        });
        let points = [
            @php
                if ($points->isNotEmpty())
                    $points->each(
function ($point) {
echo $point.',';
}
);
            @endphp
        ];
        if (points.length) {
            for (let i = 0; i < points.length; i++) {
                myMap.geoObjects.add(new ymaps.Placemark(points[i].coords, points[i].balloon, {preset: points[i].preset}));
            }
        }
    }
</script>
<div id="map"></div>