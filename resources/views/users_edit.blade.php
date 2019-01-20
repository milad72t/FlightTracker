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
                <h2>به روز رسانی اطلاعات کاربر</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <input type="hidden" name="Id" value="{{$userInfo->id}}">
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">نام <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="first-name" name="FirstName" Lang="fa-IR" value="{{ $userInfo->firstName }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('FirstName'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('FirstName')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="last-name">نام خانوادگی<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="last-name" name="LastName" Lang="fa-IR" value="{{ $userInfo->lastName}}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('LastName'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('LastName')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="user-name">نام کاربری <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="user-name" name="UserName" value="{{ $userInfo->username }}" required="required" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('UserName'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('UserName')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="roles">وضعیت کاربر <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select id="roles" name="UserStatus" value="{{ $userInfo->status }}" class="form-control" required>
                                <option value="1" selected>فعال</option>
                                <option value="2">غیر فعال</option>
                            </select>
                            @if($errors->has('UserStatus'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('UserStatus')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="password">رمز عبور
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('password'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('password')}}</h5>
                            @endif
                        </div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="password">تکرار رمز عبور
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="password" id="password" name="rePassword" class="form-control col-md-7 col-xs-12">
                            @if($errors->has('rePassword'))
                                <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('rePassword')}}</h5>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2" for="roles"> فرم های مجاز دسترسی</label>
                        <div class="col-md-3 col-sm-3 col-xs-12" style="height:100px; overflow-y: scroll; border:1px solid #cccccc;">
                            @foreach($forms as $form)
                                <div class='checkbox' style='margin-top: -5px;'><label><input type='checkbox' value="{{$form->id}}" name='FormIds[]' @if(in_array($form->id, $userInfo->permittedForms)) checked @endif >
                                        <h5 style='margin-right: 20px; margin-top:4px;'>{{$form->description}}</h5></label></div>
                            @endforeach
                        </div>
                        @if($errors->has('FormIds'))
                            <h5 style="color: red ;direction: rtl ; margin-top: 40px; margin-bottom: -3px" >{{$errors->first('FormIds')}}</h5>
                        @endif
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
