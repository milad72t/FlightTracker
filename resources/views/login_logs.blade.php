@include('dashboard_top')

<div class="row">
    <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">ورود موفق</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="false">ورود ناموفق</a>
                    </li>
            </ul>
            <div id="myTabContent2" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ورود موفق</h2>
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
                                            <th>نام کاربری</th>
                                            <th>نام</th>
                                            <th>آی پی</th>
                                            <th>زمان مراجعه</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($successLogin as $item)
                                            <tr>
                                                <td>{{$item->username}}</td>
                                                <td>{{$item->userFullName}}</td>
                                                <td>{{$item->ip}}</td>
                                                <td>{{$item->timeSh}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ورود ناموفق</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                                        <thead>
                                        <tr>
                                            <th>نام کاربری</th>
                                            <th>نام</th>
                                            <th>مشکل ورود</th>
                                            <th>آی پی</th>
                                            <th>زمان</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($failedLogin as $item)
                                            <tr>
                                                <td>{{$item->username}}</td>
                                                <td>{{$item->userFullName}}</td>
                                                <td>{{$item->typeName}}</td>
                                                <td>{{$item->ip}}</td>
                                                <td>{{$item->timeSh}}</td>
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