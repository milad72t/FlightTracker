@include('dashboard_top')

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();
    } );
</script>

<div class="row">
    <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <div id="myTabContent2" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>فرودگاه ها</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>شناسه فرودگاه</th>
                                        <th>نام فرودگاه</th>
                                        <th>کشور</th>
                                        <th>شهر</th>
                                        <th>IATA Code</th>
                                        <th>ICAO Code</th>
                                        <th>وضعیت</th>
                                        <th>طول جغرافیایی</th>
                                        <th>عرض جغرافیایی</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($airports as $airport)
                                        <tr style="cursor: pointer">
                                            <td>{{$airport->id}}</td>
                                            <td >{{$airport->name}}</td>
                                            <td >{{$airport->country}}</td>
                                            <td >{{$airport->city}}</td>
                                            <td >{{$airport->IATA_Code}}</td>
                                            <td >{{$airport->ICAO_Code}}</td>
                                            @if($airport->active)
                                                <td style="background-color: #00b300; color: #ffffff;">فعال</td>
                                            @else
                                                <td style="background-color: #ff4d4d; color: #ffffff;">غیرفعال</td>
                                            @endif
                                            <td style="direction: ltr" >{{$airport->latitude}}</td>
                                            <td style="direction: ltr" >{{$airport->longitude}}</td>
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

