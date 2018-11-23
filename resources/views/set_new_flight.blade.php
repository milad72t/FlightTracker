@include('dashboard_top')
<link href="/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/calendar_theme/aqua/theme.css">
<script src="/js/calendar/jalali.js"></script>
<script src="/js/calendar/calendar.js"></script>
<script src="/js/calendar/calendar-setup.js"></script>
<script src="/js/calendar/lang/calendar-fa.js"></script>
<script src="/js/farsitype/farsitype.js"></script>
<style>
    .col-md-1{
        width: 10%;
    }
</style>
<div class="row">
    <div class="x_content">
        <div class="x_panel">
            <div class="x_title">
                <h2>ثبت پرواز</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">شماره پرواز <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="flightNumber" name="flightNumber" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('flightNumber') }}">
                            @if($errors->has('flightNumber'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('flightNumber')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="last-name">شرکت هواپیمایی<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="airlineId" name="airlineId" class="form-control" required>
                                <option value="" selected>انتخاب نمایید...</option>
                                @foreach($airlines as $airline)
                                    <option value="{{$airline['id']}}">{{$airline['name']}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('airlineId'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('airlineId')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="user-name">مدل هواپیما <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="airPlaneId" name="airPlaneId" class="form-control" required>
                                <option value="" selected>انتخاب نمایید...</option>
                                @foreach($airplanes as $airplane)
                                    <option value="{{$airplane['id']}}">{{$airplane['name']}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('airPlaneId'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('airPlaneId')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="expired-date">تاریخ حرکت <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="departureTime" name="departureTime" requied="required" class="date-picker form-control col-md-7 col-xs-12" value="{{ old('departureTime') }}">
                            @if($errors->has('departureTime'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('departureTime')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="password">فرودگاه مبدا <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="sourceAirportId" name="sourceAirportId" class="form-control" required>
                                <option value="" selected>انتخاب نمایید...</option>
                                @foreach($airports as $airport)
                                    <option value="{{$airport['id']}}">{{$airport['name']}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('sourceAirportId'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('sourceAirportId')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="password">فرودگاه مقصد<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                        <select id="destinationAirportId" name="destinationAirportId" class="form-control" required>
                            <option value="" selected>انتخاب نمایید...</option>
                            @foreach($airports as $airport)
                                <option value="{{$airport['id']}}">{{$airport['name']}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('destinationAirportId'))
                            <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('destinationAirportId')}}</h5>
                        @endif
                    </div>
                    </div>
                    <div class="ln_solid"></div>
                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">ثبت</button>
                            <button type="reset" class="btn btn-primary">انصراف</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(session()->has('message'))
    <div class="container">
        <h2 class="text-justify"> {{session()->get('message')}} </h2>
    </div>
@endif
@include('dashboard_bottom')
<!-- Datatables -->
<script src="/vendors/datatables.net/js/jquery.dataTables.js"></script>
<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="/vendors/jszip/dist/jszip.min.js"></script>
<script src="/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="/vendors/pdfmake/build/vfs_fonts.js"></script>
<!-- Switchery -->
<script src="/vendors/switchery/dist/switchery.min.js"></script>
<script src="/js/create_flight.js"></script>
</body>
</head>


