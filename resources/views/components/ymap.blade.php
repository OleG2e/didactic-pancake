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
        let myPlacemark = new ymaps.Placemark([62.358, 50.072], {}, {
            draggable: true
        });
        myPlacemark.events.add('dragend', function (e) {
            let target = e.get('target');
            let coords = document.getElementById('coords');
            coords.value = target.geometry.getCoordinates().toString();
        });
        let map = new ymaps.Map('map', {
            center: [62.358, 50.072],
            zoom: 14
        });
        map.geoObjects.add(myPlacemark);
    }
</script>
<label class="checkbox"><input type="checkbox" id="checkbox" onclick="toggle()">Выбрать точку на карте</label>
<div id="map" style="width: 600px; height: 400px; display: none;"></div>
<input id="coords" name="coords" type="hidden">