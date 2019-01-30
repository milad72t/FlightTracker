@include('dashboard_top')
<!-- Left Side Modal -->
<div class="modal left fade" id="leftSieModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div id="image"></div>
                <p id="leftModalBody">
                </p>
                <div id="infoLink" align="center" ></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="container">
    <div class="col-lg-8 col-md-9 col-xs-12" id="map" style="position:relative ;width:''; height: 600px"></div>
    <div class="col-lg-4 col-md-3 col-xs-12" id="targetTable" style="overflow: scroll;position:relative;margin-top: 20px ; height: 600px">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>شماره پرواز</th>
                <th>سرعت</th>
                <th>ارتفاع</th>
                <th>طول جغرافیایی</th>
                <th>عرض جغرافیایی</th>
            </tr>
            </thead>
            <tbody id="TargetTable"></tbody>
        </table>
    </div>
</div>
<script>var userId = <?php echo \Illuminate\Support\Facades\Auth::user()->id ?></script>
<script type="text/javascript" src="/js/dashboardMap.js"></script>
<link rel="stylesheet" type="text/css" href="/css/mousePosition.css">

@include('dashboard_bottom')