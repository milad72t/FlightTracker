$(document).ready(function(){
    var mapOptions = {
        center: [19.093266636089712, -102.249755859375],
        zoom: 7
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
        console.log(e,map.getBounds());
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
            console.log(new Date().getTime()-ajaxTime);
            // console.log(data.data);
            $.each(data.data, function (index, element) {
                var iconOptions = {
                    iconUrl: '/images/f-icon.png',
                    iconSize: [50, 50]
                };
                var customIcon = L.icon(iconOptions);
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title: element.flightNumber+"\n"+'ارتفاع : ' + element.altitude+"\n"+' سرعت : '+element.speed+"\n"+" زاویه : "+element.angle,
                    riseOnHover	: true,
                    name : 'marker',
                    rotationAngle: element.angle,
                    icon: customIcon
                }).on('click',markerOnClick);
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

function markerOnClick(e) {
    alert("hi. you clicked the marker at " + e.target.options.name);
}