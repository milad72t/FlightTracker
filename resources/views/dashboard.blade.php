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

<div id="map" style="position:relative ; width: 100%; height: 580px"></div>


<script type="text/javascript" src="/js/dashboardMap.js"></script>
@include('dashboard_bottom')