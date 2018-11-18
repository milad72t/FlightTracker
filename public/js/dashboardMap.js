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
                    flightId : element.flightId,
                    speed : element.speed,
                    altitude : element.altitude,
                    angle : element.angle
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
    jQuery.noConflict();
    $.ajax({
        url: '/api/getFlightInfo/' + e.target.options.flightId,
        type: 'GET',
        dataType: "json",
        success: function (data) {
            $('#myModalLabel').html('جز‌ئیات پرواز');
            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead>  </thead> <tbody><tr><td>شماره پرواز</td><td>'+data.data.flightNumber+'</td></tr><tr><td>نام ایرلاین</td><td>'+data.data.airlineName+'</td></tr><tr><td>فرودگاه مبدا</td><td>'+data.data.sourceAirportName+'</td></tr><tr><td>فرودگاه مقصد</td><td>'+data.data.destinationAirportName+'</td></tr><tr><td >زمان حرکت</td><td>'+data.data.departureTime+'</td></tr><tr><td>نام هواپیما</td><td>'+data.data.airPlaneName+'</td></tr><tr><td>سرعت</td><td>'+e.target.options.speed+'</td></tr><tr><td>ارتفاع</td><td>'+e.target.options.altitude+'</td></tr><tr><td>زاویه</td><td>'+e.target.options.angle+'</td></tr></tr><tr><td>طول جغرافیایی</td><td style="direction: ltr">'+e.latlng.lat+'</td></tr></tr><tr><td>عرض جغرافیایی</td><td style="direction: ltr">'+e.latlng.lng+'</td></tr> </tbody>';
            $('#leftModalBody').html(html);
            $('#leftSieModal').modal('show');
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                icon: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                button: 'بستن'
            });
        },
        complete: function () {
        }
    });
}

function airportClick(e) {
    jQuery.noConflict();
    $.ajax({
        url: '/api/getAirportInfo/' + e.target.options.airportId,
        type: 'GET',
        dataType: "json",
        success: function (data) {
            $('#myModalLabel').html('مشخصات فرودگاه');
            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead>  </thead> <tbody><tr><td>نام فرودگاه</td><td>'+data.data.name+'</td></tr><tr><td>کشور</td><td>'+data.data.country+'</td></tr><tr><td>شهر</td><td>'+data.data.city+'</td></tr><tr><td>IATA Code</td><td>'+data.data.IATA_Code+'</td></tr><tr><td >ICAO Code</td><td>'+data.data.ICAO_Code+'</td></tr><tr><td>طول جغرافیایی</td><td style="direction: ltr">'+data.data.latitude+'</td></tr><tr><td>عرض جغرافیایی</td><td style="direction: ltr">'+data.data.longitude+'</td></tr> </tbody>';
            $('#leftModalBody').html(html);
            $('#leftSieModal').modal('show');
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                icon: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                button: 'بستن'
            });
        },
        complete: function () {
        }
    });
}