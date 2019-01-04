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
                <h2>تغییر تنظیمات</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        <div class="x_content">
        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <div class="form-group">
                @foreach($settings as $setting)
                    <div class="form-group">
                    <label class="control-label col-md-1 col-sm-1 col-xs-12" style="width: 30%" for="id-number">{{$setting->description}}
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" id="{{$setting->name}}" name="{{$setting->name}}"  required="required" maxlength="50" value="{{$setting->value}}">
                    </div>
                    </div>
                    <hr style="border-top: dotted 1px;" />
                @endforeach
            </div>
            {{csrf_field()}}
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">به روز رسانی</button>
                </div>
            </div>
        </form>
</div>
</div>
</div>
</div>

@include('dashboard_bottom')
