$(document).ready(function(){
    var mapOptions = {
        center: [35.70247433100471, 51.40193939208985],
        zoom: 7,
    };
    var map = new L.map('map', mapOptions);
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);
    var scale = L.control.scale();
    scale.addTo(map);
    map.on('click', function(e) {
        addLatLng(e,map);
    });
});

function addLatLng(e,map) {
    map.eachLayer(function (layer) {
        if(layer.options.name === 'airport'){
            map.removeLayer(layer);
        }
    });
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    $('#latitude').val(lat);
    $('#longitude').val(lng);
    var marker = new L.marker(e.latlng,{
        name : 'airport'
    }).addTo(map);
}