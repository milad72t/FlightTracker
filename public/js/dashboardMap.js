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
            // console.log(data.airports);
            var flightIcon = {
                iconUrl: '/images/f-icon.png',
                iconSize: [50, 50]
            };
            var customFlightIcon = L.icon(flightIcon);
            $.each(data.flights, function (index, element) {
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title: element.flightNumber+"\n"+'ارتفاع : ' + element.altitude+"\n"+' سرعت : '+element.speed+"\n"+" زاویه : "+element.angle,
                    riseOnHover	: true,
                    name : 'marker',
                    rotationAngle: element.angle,
                    icon: customFlightIcon,
                    flightId : element.flightId
                }).on('click',markerOnClick);
                marker.addTo(map);
            });
            var airportIcon = {
                iconUrl: '/images/airport-icon.png',
                iconSize: [25, 25]
            };
            var customAirportIcon = L.icon(airportIcon);
            $.each(data.airports, function (index, element) {
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title: element.name,
                    name : 'marker',
                    icon: customAirportIcon,
                    airportId : element.id
                }).on('click',airportClick);
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
    alert("hi. you clicked the marker at " + e.target.options.flightId);
}

function airportClick(e) {
    alert("hi. you clicked the airport at " + e.target.options.airportId);
}