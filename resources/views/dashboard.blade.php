@include('dashboard_top')
<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
<link href="/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="/vendors/sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="/vendors/sweetalert-master/dist/sweetalert.css">
<style>
    .modal_l {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .3 )
        url('/images/loading_gif.gif')
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
    .axisLabel {
        position: absolute;
        text-align: center;
        font-size: 12px;
    }
    .xaxisLabel {
        bottom: -35px;
        left: 0;
        right: 0;
    }
    .yaxisLabel {
        top: 50%;
        left: -20px;
        transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -webkit-transform:  rotate(-90deg);
        transform-origin: 0 0;
        -o-transform-origin: 0 0;
        -ms-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
        -webkit-transform-origin: 0 0;
    }
    div.xAxis div.tickLabel {
        transform: rotate(-90deg);
        -ms-transform:rotate(-90deg); /* IE 9 */
        -moz-transform:rotate(-90deg); /* Firefox */
        -webkit-transform:rotate(-90deg); /* Safari and Chrome */
        -o-transform:rotate(-90deg); /* Opera */
    }
</style>
<script src="/js/numeral/numeral.min.js"></script>

<div id="show_modal" data-toggle="modal" data-target="#myModal" ></div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="text-align: center;">تعداد مشترکین به تفکیک شرکت توزیع</h4>
            </div>
            <div id="modal_content" class="modal-header">

            </div>

        </div>

    </div>
</div>

</div>

@include('dashboard_bottom')

<div class="modal_l"><!-- Place at bottom of page --></div>

{{--<script>var ssi = "{{Session::get('token')}}"</script>--}}
<script src="/js/dashboard.js"></script>

