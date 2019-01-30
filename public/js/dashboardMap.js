$(document).ready(function(){
    $.getScript("/js/mousePosition.js", function(){
    var mapOptions = {
        center: [19.093266636089712, -102.249755859375],
        zoom: 7,
    };
    var map = new L.map('map', mapOptions);
    var options = {
        primaryLengthUnit : 'kilometers',
        secondaryLengthUnit : undefined,
        primaryAreaUnit : 'sqmeters',
        completedColor : '#e80b25',
        activeColor : '#04e508'
    };
    var measureControl = new L.Control.Measure(options);
    measureControl.addTo(map);
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);
    var scale = L.control.scale();
    L.control.mousePosition({
        prefix: 'mouse position : '
    }).addTo(map);
    scale.addTo(map);
    fetchData(map);
    var searchControl = new L.esri.Controls.Geosearch().addTo(map);
    var results = new L.LayerGroup().addTo(map);
    searchControl.on('results', function(data){
        results.clearLayers();
        for (var i = data.results.length - 1; i >= 0; i--) {
            results.addLayer(L.marker(data.results[i].latlng));
        }
    });
    setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
        setInterval(function(){fetchData(map);},4000);
    map.on('moveend', function () {
        fetchData(map);
    });
    map.on('click', function(e) {
        addPin(e.latlng.lat,e.latlng.lng,map);
    });
    $("#removeTargetTable").click(function () {
        $("#targetTable").toggle();
        var isTableHidden = $("#targetTable").is(":hidden");
        if(isTableHidden)
            $("#map").css('width','100%');
        else
            $("#map").css('width','');
    })
    });
});


function fetchData(map) {
    addMarker(map);
}

function getValuesOfArray(data) {
    var b =[];
    for(var i=0; i<data.length; i++) {
        b.push([data[i].latitude,data[i].longitude])
    }
    return b;
}


function addMarker(map) {
    var ajaxTime= new Date().getTime();
    var zoomLevel = map.getZoom();
    var getAirport;
    if(zoomLevel >=6)
        getAirport = 1;
    else
        getAirport = 0;
    $.get('/api/getLiveFlightsLog?east='+map.getBounds().getEast()+'&west='+map.getBounds().getWest()
        +'&north='+map.getBounds().getNorth()+'&south='+map.getBounds().getSouth()+'&getAirports='+getAirport+'&id='+userId,
        function(data,status){
            removeMarkers(map);
            console.log(new Date().getTime()-ajaxTime);
            var flightIcon = {
                iconUrl: '/images/f-icon.png',
                iconSize: [50, 50]
            };
            var customFlightIcon = L.icon(flightIcon);
            $("tbody").html('');
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
                }).on('click',function (e) {
                    markerOnClick(e,map);
                });
                marker.addTo(map);
                var flightRow = '<tr><td>'+element.flightNumber+'</td><td>'+element.speed+'</td><td>'+element.altitude+'</td><td>'+element.latitude+'</td><td>'+element.longitude+'</td></tr>';
                $("tbody").append(flightRow);
                var polyline = L.polyline(getValuesOfArray(element.lastNPoint), {
                    color: 'green',
                    weight: 5,
                    opacity: .4,
                    dashArray: '8,5',
                    lineJoin: 'round'});
                polyline.addTo(map);
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
            $.each(data.userPins,function (index,element){
                var pinIcon = {
                    iconUrl: '/images/type-'+element.type+'.png',
                    iconSize: [40, 35]
                };
                var customPinIcon = L.icon(pinIcon);
                var marker = new L.Marker([element.latitude, element.longitude],{
                    title: element.name,
                    name : 'marker',
                    icon: customPinIcon,
                    pinId : element.id
                }).on('click',deletePin);
                marker.addTo(map);
            })
        });
}

function removeMarkers(map) {
    map.eachLayer(function (layer) {
        if(layer.options.name === 'marker'){
            map.removeLayer(layer);
        }
    });
}

function markerOnClick(e,map) {
    jQuery.noConflict();
    $.ajax({
        url: '/api/getFlightInfo/' + e.target.options.flightId,
        type: 'GET',
        dataType: "json",
        success: function (data) {
            var polyline = L.polyline(data.data.layerLatLng,
                {
                color: 'red',
                weight: 3,
                opacity: .6,
                dashArray: '8,5',
                lineJoin: 'round'});
            polyline.addTo(map);
            $('#myModalLabel').html('جز‌ئیات پرواز');
            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead>  </thead> <tbody><tr><td>شماره پرواز</td><td>'+data.data.flightNumber+'</td></tr><tr><td>نام ایرلاین</td><td>'+data.data.airlineName+'</td></tr><tr><td>فرودگاه مبدا</td><td>'+data.data.sourceAirportName+'</td></tr><tr><td>فرودگاه مقصد</td><td>'+data.data.destinationAirportName+'</td></tr><tr><td >زمان حرکت</td><td>'+data.data.departureTime+'</td></tr><tr><td>نام هواپیما</td><td>'+data.data.airPlaneName+'</td></tr><tr><td>سرعت</td><td>'+e.target.options.speed+'</td></tr><tr><td>ارتفاع</td><td>'+e.target.options.altitude+'</td></tr><tr><td>زاویه</td><td>'+e.target.options.angle+'</td></tr></tr><tr><td>طول جغرافیایی</td><td style="direction: ltr">'+e.latlng.lat+'</td></tr></tr><tr><td>عرض جغرافیایی</td><td style="direction: ltr">'+e.latlng.lng+'</td></tr> </tbody>';
            $('#leftModalBody').html(html);
            var infoLink = '<form method="post" action="/searchFlight"><input type="hidden" id="flightId" name="flightId" value='+e.target.options.flightId+'> <button type="submit" id="form_submit" class="btn btn-info" style="width: 80%;">مشاهده جزئیات پرواز</button></form>';
            $('#infoLink').html(infoLink);
            var image = '<img align="center" style="width: 100%;margin-bottom: 0px" src="images/plane-'+data.data.airPlaneId+'.JPG">';
            $('#image').html(image);
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
            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead>  </thead> <tbody><tr><td>نام فرودگاه</td><td>'+data.data.name+'</td></tr><tr><td>کشور</td><td>'+data.data.country+'</td></tr><tr><td>شهر</td><td>'+data.data.city+'</td></tr><tr><td>IATA Code</td><td>'+data.data.IATA_Code+'</td></tr><tr><td >ICAO Code</td><td>'+data.data.ICAO_Code+'</td></tr><tr><td >ارتفاع (فیت)</td><td>'+data.data.altitude+'</td></tr><tr><td>طول جغرافیایی</td><td style="direction: ltr">'+data.data.latitude+'</td></tr><tr><td>عرض جغرافیایی</td><td style="direction: ltr">'+data.data.longitude+'</td></tr> </tbody>';
            $('#leftModalBody').html(html);
            var infoLink = '';
            $('#infoLink').html(infoLink);
            var image = '<img align="center" style="width: 100%;margin-bottom: 0px" src="images/airport.JPG">';
            $('#image').html(image);
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


function addPin(lat,lng,map){
    swal("لطفا نامی برای مکان خود انتخاب کنید:", {
        content: "input",
    }).then((value) => {
        if (!value) return null;
        var name = value;
    swal("لطفا نوع آیکون را انتخاب نمایید", {
        buttons: {
            black: {
                text: "مشکی",
                value: 1,
            },
            iran: {
                text: "پرچم ایران",
                value: 2,
            },
            red: {
                text: "پرچم قرمز",
                value: 3,
            },
            green: {
                text: "پرچم سبز",
                value: 4,
            },
            orange: {
                text: "نارنجی",
                value: 5,
            },
            cancel: "لغو",
        },
    }).then((value) => {
        if (!value) return null;
        $.ajax({
        url: '/api/addPin',
        dataType: 'json',
        type: 'post',
        contentType: 'application/json',
        data : JSON.stringify({'userId':userId,'name':name,'type':value,'latitude':lat,'longitude':lng}),
        success : function(response){
            if(response.status == 200 ){
                swal("انجام شد!", "اضافه کردن مکان شما با موفقیت انجام شد", "success");
                fetchData(map);
            }else{
                console.log(response);
                swal({
                    title: 'در اضافه کردن مکان شما مشکلی پیش آمده است',
                    icon: 'error',
                    background: '#fff url(//bit.ly/1Nqn9HU)',
                    button: 'بستن'
                });
            }
        },
        error: function (response) {
            console.log(response);
            swal({
                title: 'متاسفانه اضافه کردن مکان شما در حال حاضر میسر نیست',
                icon: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                button: 'بستن'
            });
        }

    });
    });
    });
}

function deletePin(e) {
    swal({
        title: "آیا اطمینان دارید؟",
        text: "آیا مطمئن به حذف این مکان هستید؟؟",
        icon: "warning",
        // buttons: true,
        buttons: ["لغو", "بلی"],
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: '/api/removePin/'+e.target.options.pinId,
                dataType: 'json',
                type: 'get',
                contentType: 'application/json',
                success: function (response){
                    if(response.status == 200 ){
                        swal("انجام شد!", response.msg, "success");
                    }else{
                        swal("ناموفق!", response.msg, "error");
                    }
                },
                error: function (response) {
                    console.log(response);
                    swal({
                        title: 'متاسفانه اضافه کردن مکان شما در حال حاضر میسر نیست',
                        icon: 'error',
                        background: '#fff url(//bit.ly/1Nqn9HU)',
                        button: 'بستن'
                    });
                }
            });
        } else {
            swal('حذف مکان شما لغو شد');
        }
    });
}