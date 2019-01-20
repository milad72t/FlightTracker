@include('dashboard_top')

<script type="text/javascript">
    $(document).ready(function() {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
        $('#datatable').DataTable();
    });
</script>

<div class="row">
    <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <div id="myTabContent2" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>ایرلاین ها</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                    <tr>
                                        <th>شناسه ایرلاین</th>
                                        <th>نام ایرلاین</th>
                                        <th>نام مستعار</th>
                                        <th>IATA Code</th>
                                        <th>ICAO Code</th>
                                        <th>CallSign</th>
                                        <th>کشور</th>
                                        <th>وضعیت</th>
                                    </tr>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($airlines as $airline)
                                        <tr class='clickable-row' data-href='/airlines/edit/{{$airline->id}}' style="cursor: pointer">
                                        <td>{{$airline->id}}</td>
                                        <td >{{$airline->name}}</td>
                                        <td >{{$airline->alias}}</td>
                                        <td >{{$airline->IATA_Code}}</td>
                                        <td >{{$airline->ICAO_Code}}</td>
                                        <td >{{$airline->callSign}}</td>
                                        <td >{{$airline->country}}</td>
                                        @if($airline->active ==1)
                                            <td style="background-color: #00b300; color: #ffffff;">فعال</td>
                                        @else
                                            <td style="background-color: #ff4d4d; color: #ffffff;">غیرفعال</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard_bottom')

