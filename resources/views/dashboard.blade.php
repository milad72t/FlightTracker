<!DOCTYPE html>
<html>
<head>
    <title>Leaflet sample</title>
    <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>
    <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
</head>

<body>
<div id = "map" style = "width: 900px; height: 580px"></div>
<script>
    // Creating map options
    var mapOptions = {
        center: [35.7464753, 51.3794186],
        zoom: 10
    }

    // Creating a map object
    var map = new L.map('map', mapOptions);
    var marker = new L.Marker([35.7464753, 51.3794186],{
        title: "MyLocation",
        clickable: true,
        draggable: true
    });
    marker.addTo(map);

    // Creating a Layer object
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

    // Adding layer to the map
    map.addLayer(layer);
</script>
</body>

</html>