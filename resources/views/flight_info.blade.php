@include('dashboard_top')
<script>
    $(document).ready(function(){
        var mapOptions = {
            center: [16.506174, 80.648015],
            zoom: 7
        };
        var map = new L.map('map', mapOptions);
        var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);
        var latlngs = [
            [17.385044, 78.486671],
            [16.506174, 80.648015],
            [17.000538, 81.804034],
            [17.686816, 83.218482]
        ];
        var polyline = L.polyline(latlngs, {color: 'red'});
        polyline.addTo(map);
    });

</script>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>مشاهده اطلاعات کامل پرواز</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="map" style="position:relative ; width: 100%; height: 300px"></div>
            <h2>مشخصات پرواز</h2>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>شناسه پرواز</th>
                    <th>شماره پرواز</th>
                    <th>زمان حرکت</th>
                    <th>زمان پایان</th>
                    <th>وضعیت پرواز</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$flightInfo->id}}</td>
                        <td >{{$flightInfo->flightNumber}}</td>
                        <td >{{$flightInfo->departureTime}}</td>
                        <td >{{$flightInfo->arrivalTime}}</td>
                        @if($flightInfo->finished)
                            <td style="background-color: #ff4d4d; color: #ffffff;">پایان یافته</td>
                        @else
                            <td style="background-color: #00b300; color: #ffffff;">در حال پرواز</td>
                        @endif
                    </tr>
                </tbody>
            </table>

            @if($flightInfo->last_flight_log)
                <h2>آخرین لاگ ارسالی</h2>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ارتفاع</th>
                        <th>سرعت</th>
                        <th>زاویه</th>
                        <th>زمان ارسال</th>
                        <th>طول جغرافیایی</th>
                        <th>عرض جغرافیایی</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$flightInfo->last_flight_log->altitude}}</td>
                        <td >{{$flightInfo->last_flight_log->speed}}</td>
                        <td >{{$flightInfo->last_flight_log->angle}}</td>
                        <td >{{$flightInfo->last_flight_log->sendTime}}</td>
                        <td style="direction: ltr">{{$flightInfo->last_flight_log->latitude}}</td>
                        <td style="direction: ltr">{{$flightInfo->last_flight_log->longitude}}</td>
                    </tr>
                    </tbody>
                </table>
            @endif

            <h2>مشخصات ایرلاین</h2>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>شناسه ایرلاین</th>
                    <th>نام ایرلاین</th>
                    <th>نام مستعار</th>
                    <th>IATA Code</th>
                    <th>ICAO Code</th>
                    <th>CallSign</th>
                    <th>کشور</th>
                    <th>وضعیت</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$flightInfo->airline->id}}</td>
                    <td >{{$flightInfo->airline->name}}</td>
                    <td >{{$flightInfo->airline->alias}}</td>
                    <td >{{$flightInfo->airline->IATA_Code}}</td>
                    <td >{{$flightInfo->airline->ICAO_Code}}</td>
                    <td >{{$flightInfo->airline->callSign}}</td>
                    <td >{{$flightInfo->airline->country}}</td>
                    @if($flightInfo->airline->active)
                        <td style="background-color: #00b300; color: #ffffff;">فعال</td>
                    @else
                        <td style="background-color: #ff4d4d; color: #ffffff;">غیرفعال</td>
                    @endif
                </tr>
                </tbody>
            </table>
            <h2>مشخصات هواپیما</h2>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>شناسه هواپیما</th>
                    <th>مدل هواپیما </th>
                    <th>IATA Code</th>
                    <th>ICAO Code</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$flightInfo->airplane->id}}</td>
                    <td >{{$flightInfo->airplane->name}}</td>
                    <td >{{$flightInfo->airplane->IATA_Code}}</td>
                    <td >{{$flightInfo->airplane->ICAO_Code}}</td>
                </tr>
                </tbody>
            </table>
            <h2>فرودگاه مبدا</h2>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>شناسه فرودگاه</th>
                    <th>نام فرودگاه</th>
                    <th>کشور</th>
                    <th>شهر</th>
                    <th>IATA Code</th>
                    <th>ICAO Code</th>
                    <th>وضعیت</th>
                    <th>طول جغرافیایی</th>
                    <th>عرض جغرافیایی</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$flightInfo->source_airport->id}}</td>
                    <td >{{$flightInfo->source_airport->name}}</td>
                    <td >{{$flightInfo->source_airport->country}}</td>
                    <td >{{$flightInfo->source_airport->city}}</td>
                    <td >{{$flightInfo->source_airport->IATA_Code}}</td>
                    <td >{{$flightInfo->source_airport->ICAO_Code}}</td>
                    @if($flightInfo->source_airport->active)
                        <td style="background-color: #00b300; color: #ffffff;">فعال</td>
                    @else
                        <td style="background-color: #ff4d4d; color: #ffffff;">غیرفعال</td>
                    @endif
                    <td style="direction: ltr" >{{$flightInfo->source_airport->latitude}}</td>
                    <td style="direction: ltr" >{{$flightInfo->source_airport->longitude}}</td>
                </tr>
                </tbody>
            </table>
            <h2>فرودگاه مقصد</h2>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>شناسه فرودگاه</th>
                    <th>نام فرودگاه</th>
                    <th>کشور</th>
                    <th>شهر</th>
                    <th>IATA Code</th>
                    <th>ICAO Code</th>
                    <th>وضعیت</th>
                    <th>طول جغرافیایی</th>
                    <th>عرض جغرافیایی</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$flightInfo->dest_air_port->id}}</td>
                    <td >{{$flightInfo->dest_air_port->name}}</td>
                    <td >{{$flightInfo->dest_air_port->country}}</td>
                    <td >{{$flightInfo->dest_air_port->city}}</td>
                    <td >{{$flightInfo->dest_air_port->IATA_Code}}</td>
                    <td >{{$flightInfo->dest_air_port->ICAO_Code}}</td>
                    @if($flightInfo->dest_air_port->active)
                        <td style="background-color: #00b300; color: #ffffff;">فعال</td>
                    @else
                        <td style="background-color: #ff4d4d; color: #ffffff;">غیرفعال</td>
                    @endif
                    <td style="direction: ltr" >{{$flightInfo->dest_air_port->latitude}}</td>
                    <td style="direction: ltr" >{{$flightInfo->dest_air_port->longitude}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('dashboard_bottom')
