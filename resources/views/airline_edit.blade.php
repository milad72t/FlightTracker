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
                <h2>به روز رسانی اطلاعات شرکت هواپیمایی (ایرلاین)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <input type="hidden" name="Id" value="{{$airlineInfo->id}}">
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">نام ایرلاین <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="name" name="name" Lang="fa-IR" value="{{ $airlineInfo->name }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('name'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('name')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="alias">نام مستعار (alias)</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="alias" name="alias" Lang="fa-IR" value="{{ $airlineInfo->alias }}"  class="form-control col-md-7 col-xs-12">
                            @if($errors->has('alias'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('alias')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="IATA_Code">IATA_Code
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="IATA_Code" name="IATA_Code" value="{{ $airlineInfo->IATA_Code }}" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('IATA_Code'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('IATA_Code')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="roles">ICAO_Code</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="ICAO_Code" name="ICAO_Code" value="{{ $airlineInfo->ICAO_Code }}" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('ICAO_Code'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('ICAO_Code')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="callSign">callSign</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="callSign" value="{{$airlineInfo->callSign}}" name="callSign" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('callSign'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('callSign')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="country">کشور</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="country" value="{{$airlineInfo->country}}" name="country" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('country'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('country')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="roles">وضعیت ایرلاین <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="status" name="status" class="form-control" required>
                                <option value="1" @if ( $airlineInfo->active  ==1) selected @endif >فعال</option>
                                <option value="2" @if ( $airlineInfo->active  ==2) selected @endif>غیر فعال</option>
                            </select>
                            @if($errors->has('status'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('status')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                        </div>
                        <div class="ln_solid"></div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">به روز رسانی</button>
                                <button type="reset" class="btn btn-primary">انصراف</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('dashboard_bottom')
