@include('dashboard_top')
<style>
    .col-md-1{
        width: 10%;
    }
</style>
<div class="row">
    <div class="x_content">
        <div class="x_panel">
            <div class="x_title">
                <h2>ثبت اطلاعات فرودگاه</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">نام فرودگاه <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="name" name="name" Lang="fa-IR" value="{{ old('name') }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('name'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('name')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="roles">وضعیت فرودگاه <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="status" name="status" value="{{ old('status') }}" class="form-control" required>
                                <option value="1" selected>فعال</option>
                                <option value="2">غیر فعال</option>
                            </select>
                            @if($errors->has('status'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('status')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="IATA_Code">IATA_Code <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="IATA_Code" name="IATA_Code" value="{{ old('IATA_Code') }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('IATA_Code'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('IATA_Code')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="roles">ICAO_Code</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="ICAO_Code" name="ICAO_Code" value="{{ old('ICAO_Code') }}" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('ICAO_Code'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('ICAO_Code')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="country"> کشور<span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="country" name="country" value="{{ old('country') }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('country'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('country')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="city"> شهر<span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="city" name="city" value="{{ old('city') }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('city'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('city')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="latitude">طول جغرافیایی  <span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required="required" class="form-control col-md-7 col-xs-12" readonly>
                            @if($errors->has('latitude'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('latitude')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="longitude"> عرض جغرافیایی <span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" required="required" class="form-control col-md-7 col-xs-12" readonly>
                            @if($errors->has('longitude'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('longitude')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <br>
                        <div id="map" style="position:relative ; width: 90%; height: 410px"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                        </div>
                        <div class="ln_solid"></div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">ثبت</button>
                                <button type="reset" class="btn btn-primary">انصراف</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/addAirport.js"></script>
@include('dashboard_bottom')
