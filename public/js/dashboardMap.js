$(document).ready(function(){
    var mapOptions = {
        center: [28.363816, -81.569289],
        zoom: 5
    }

    var map = new L.map('map', mapOptions);
    $.post("/api/getLiveFlightsLog",
        {
            "CenterLat":mapOptions.center[0],
            "CenterLong":mapOptions.center[1],
            "ZoomLevel":mapOptions.zoom
        },
        function(data,status){
            $.each(data.data, function (index, element) {
                var iconOptions = {
                    iconUrl: '/images/f-icon.png',
                    iconSize: [30, 30]
                };
                var customIcon = L.icon(iconOptions);
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title:'altitude :'+ element.altitude+' , speed :'+element.speed,
                    icon: customIcon
                });
                marker.addTo(map);
            });

        });
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);
});