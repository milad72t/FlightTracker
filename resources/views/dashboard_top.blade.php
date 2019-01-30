<?php
$permittedForms = \Illuminate\Support\Facades\Cache::remember('PermForms_'.\Illuminate\Support\Facades\Auth::user()->id,60*8,function (){
    return \Illuminate\Support\Facades\Auth::user()->permittedFormsName();
});
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <!-- CDN added (for modal) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>سامانه مشاهده بلادرنگ پروازها</title>

    <!-- Bootstrap -->
    {{--<link href="/vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">--}}
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/build/css/custom.css" rel="stylesheet">
    <link rel="icon" href="/images/SepahLogo-min.png">
    <link href="/css/left-side-modal.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/dashboard" class="site_title"><img src="/images/SepahLogo-min.png" style=" height: 45px; width: 45px" >
                        <span style="font-size: 12px">سامانه مشاهده پروازها</span></a>
                </div>
                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="/images/default-profile.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>خوش آمدید</span>
                        <h2>{{Session::get('name')}}</h2>
                    </div>
                </div>
                <br />
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                                <li><a href="/dashboard"><i class="fa fa-globe"></i> نقشه<span class="fa fa-chevron-left"></span></a></li>
                                <li><a><i class="fa fa-plane"></i> مدیریت پروازها <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @if(in_array('addFlight',$permittedForms))
                                            <li><a href="/setNewFlight">اضافه کردن پرواز</a></li>
                                        @endif
                                        @if(in_array('searchFlight',$permittedForms))
                                            <li><a href="/searchFlight">جستجوی پرواز</a></li>
                                        @endif
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-road"></i> مدیریت فرودگاه ها <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                     @if(in_array('showAirports',$permittedForms))
                                        <li><a href="/airports/show">مشاهده فرودگاه ها</a></li>
                                     @endif
                                     @if(in_array('addAirports',$permittedForms))
                                        <li><a href="/airports/add">اضافه کردن فرودگاه</a></li>
                                     @endif
                                    </ul>
                                </li>
                            <li><a><i class="fa fa-location-arrow"></i> مدیریت ایرلاین ها <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                 @if(in_array('showAirlines',$permittedForms))
                                    <li><a href="/airlines/show">مشاهده ایرلاین ها</a></li>
                                 @endif
                                 @if(in_array('addAirlines',$permittedForms))
                                    <li><a href="/airlines/add">اضافه کردن ایرلاین</a></li>
                                 @endif
                                </ul>
                            </li>
                            <li><a><i class="fa fa-users"></i> مدیریت کاربران <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                 @if(in_array('showUsers',$permittedForms))
                                    <li><a href="/users/show">مشاهده کاربران</a></li>
                                 @endif
                                  @if(in_array('addUser',$permittedForms))
                                    <li><a href="/users/create">اضافه کردن کاربر</a></li>
                                  @endif
                                  @if(in_array('loginLogs',$permittedForms))
                                    <li><a href="/loginLogs/show">مشاهده مراجعات</a></li>
                                  @endif
                                </ul>
                            </li>
                            <li><a><i class="fa fa-file-text-o"></i> سایر <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                @if(in_array('settings',$permittedForms))
                                    <li><a href="/settings/show">تنظیمات</a></li>
                                @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small" style="display: none;">
                    <a data-toggle="tooltip" data-placement="top" title="Settings" >
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="/logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>


        <!-- top navigation -->
        <div class="top_nav" >
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    @if(\Illuminate\Support\Facades\Route::current()->getName())
                        <button type="button" id="removeTargetTable" class="btn btn-primary" style="margin-top: 10px">حذف جدول هدف</button>
                        <button type="button" id="enableAddPin" class="btn btn-primary" style="margin-top: 10px">فعال کردن افزودن مکان</button>
                    @endif
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="/images/default-profile.jpg" alt="">گزینه ها
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="/dashboard/changePassword"> تغییر رمز عبور<span class="fa fa-edit" style="margin-right: 70px;"></span></a></li>
                                </li>
                                <li>
                                    <a href="/logout"> خروج<span class="fa fa-sign-out"></span></a></li>

                            </ul>
                        </li>
                        </li>
                                <li>
                                    <div class="text-center">
                                    </div>
                                </li>
                            </ul>
                    </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @if(session()->has('notification'))
                <div class="row">
                    <div class="alert alert-info" style="color: #0000F0; margin-top:0;" role="alert" dir="rtl">
                        <button type="button" class="close" data-dismiss="alert" style="float: left">×</button>
                        {{session()->get('notification')}}
                    </div>
                </div>
            @endif

