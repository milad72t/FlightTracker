@include('dashboard_top')

<div class="row">
    <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <div id="myTabContent2" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>کاربران</h2>
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
                                            <th>ردیف</th>
                                            <th>نام کاربری</th>
                                            <th>نام</th>
                                            <th>نام خانوادگی</th>
                                            <th>وضعیت</th>
                                            <th>آخرین مراجعه</th>
                                            <th>تاریخ ایحاد</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($users as $index=>$item)
                                            <tr style="cursor: pointer">
                                                <td>{{$index +1}}</td>
                                                <td>{{$item->username}}</td>
                                                <td>{{$item->firstName}}</td>
                                                <td>{{$item->lastName}}</td>
                                                <td>{{$item->UserStatus}}</td>
                                                <td>{{$item->LastLoginSh}}</td>
                                                <td>{{$item->CreatedAtSh}}</td>
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

