$(document).ready(function(){
    var mapOptions = {
        center: [28.363816, -81.569289],
        zoom: 5
    };
    var map = new L.map('map', mapOptions);
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);
    var scale = L.control.scale();
    scale.addTo(map);
    fetchData(map);
    setInterval(function(){fetchData(map);},4000);
    map.on('moveend', function () {
        fetchData(map);
    });
    map.on('click', function(e) {
        // console.log(e);
    });
});


function fetchData(map) {
    addMarker(map);
}

function addMarker(map) {
    var ajaxTime= new Date().getTime();
    $.get('/api/getLiveFlightsLog?east='+map.getBounds().getEast()+'&west='+map.getBounds().getWest()
        +'&north='+map.getBounds().getNorth()+'&south='+map.getBounds().getSouth(),
        function(data,status){
            removeMarkers(map);
            // console.log(new Date().getTime()-ajaxTime);
            $.each(data.data, function (index, element) {
                var iconOptions = {
                    iconUrl: '/images/f-icon.png',
                    iconSize: [30, 30]
                };
                var customIcon = L.icon(iconOptions);
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title:'ارتفاع : '+ element.altitude+' , سرعت : '+element.speed+' , زاویه : '+element.angle,
                    riseOnHover	: true,
                    name : 'marker',
                    icon: customIcon
                });
                marker.addTo(map);
            });
        });
}

function removeMarkers(map) {
    map.eachLayer(function (layer) {
        if(layer.options.name === 'marker'){
            map.removeLayer(layer);
        }
    });
}