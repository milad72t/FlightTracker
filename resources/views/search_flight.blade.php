@include('dashboard_top')

<style>
    .modal_l {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 )
        url("/images/loading_gif.gif")
        50% 50%
        no-repeat;
    }
    body.loading {
        overflow: hidden;
    }
    body.loading .modal_l {
        display: block;
    }
    .sweet-alert {
        display: inline-block;
        text-decoration: none;
        font-family: "b yekan", "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>جستجوی پرواز</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="searchFlightForm" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group importing">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="roles">شناسه پرواز<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="flightId" name="flightId" required="required" class="number_input form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" id="form_submit" class="btn btn-success">جستجو</button>
                        </div>
                    </div>
                </form>
                @if(session()->has('message'))
                    <div class="container">
                        <h2 class="text-justify"> {{session()->get('message')}} </h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('dashboard_bottom')