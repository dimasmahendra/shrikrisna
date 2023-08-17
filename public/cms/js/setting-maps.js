var lat = document.getElementById('latitude').value;
var long = document.getElementById('longitude').value;
var zoom = document.getElementById('zoomlevel').value;

var map = L.map('map_canvas').setView([lat, long], zoom);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

marker = new L.marker(new L.LatLng(lat, long), {
    draggable: 'true'
});
marker.on('dragend', function (e) {
    document.getElementById('latitude').value = marker.getLatLng().lat;
    document.getElementById('longitude').value = marker.getLatLng().lng;
});
map.addLayer(marker);

map.on('zoomend', function (e) {
    document.getElementById('zoomlevel').value = map.getZoom();
});

var searchControl = new L.esri.Controls.Geosearch().addTo(map);
var results = new L.LayerGroup().addTo(map);

searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
        var searchMarker = L.marker(data.results[i].latlng, {
            draggable: 'true'
        });

        document.getElementById('latitude').value = searchMarker.getLatLng().lat;
        document.getElementById('longitude').value = searchMarker.getLatLng().lng;

        searchMarker.on('dragend', function (e) {
            var _marker = e.target;
            document.getElementById('latitude').value = _marker.getLatLng().lat;
            document.getElementById('longitude').value = _marker.getLatLng().lng;
        });

        results.addLayer(searchMarker);
    }
});