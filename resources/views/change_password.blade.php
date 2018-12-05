@include('dashboard_top')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تغییر گذرواژه</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form method="post" data-parsley-validate class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">گذرواژه ی فعلی <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="oldPassword" type="password" id="oldPassword" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">گذرواژه ی جدید <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" id="newPassword" name="newPassword" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">تکرار گذرواژه جدید<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="middle-name" class="form-control col-md-7 col-xs-12" required="required" type="password" name="newPassword_confirmation">
                            @if($errors->has('newPassword'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('newPassword')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">اعمال کن</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@include('dashboard_bottom')
