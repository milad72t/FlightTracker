<html lang="fa">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>سامانه رویت بلادرنگ پرازها</title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/vendors/animate.css/animate.min.css" rel="stylesheet">
    <script src="/vendors/sweetalert-master/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/vendors/sweetalert-master/dist/sweetalert.css">

    <!-- Custom Theme Style -->
    {{-- convert to min later --}}
    <link href="/build/css/custom.css" rel="stylesheet">

    <link rel="icon" href="/images/SepahLogo-min.png">
    <style>
        .loader {
            border: 5px solid #f3f3f3; /* Light grey */
            border-top: 5px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .sweet-alert {
            display: inline-block;
            text-decoration: none;
            font-family: "b yekan", "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        }
        .background {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .bgLogin {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-image: url("/images/bg-login.jpg");
            background-position: center center;
            background-size: cover;
            z-index: 1;
        }

        body.login {
            height: auto !important;
        }
    </style>
</head>

<body class="login">
<div class="bgLogin">
    {{--<canvas class="background"></canvas>--}}
    <div id="particles-js"></div>
</div>

<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form login_form_cover">
            <section class="login_content">
                <img height="70px" width="70px" style="margin-top: -11px" src="/images/SepahLogo-min.png"><br>
                <form method="post" id="loginForm">
                    {{csrf_field()}}
                    <h2 style="color: #ffffff; margin-bottom: 45px; margin-top: 30px">سامانه مشاهده بلادرنگ پروازها</h2>
                    <div hidden id="loading-image" style="margin-bottom: 10px;">
                        <div class="loader" style="display: inline-block;">
                        </div>
                    </div>
                    <div id="errorForm" style="color:red ;font-size: medium ;display:none; "><i
                                class="fa fa-exclamation-triangle"></i> رمز عبور یا نام کاربری اشتباه می‌باشد.
                    </div>
                    <div>
                        <input type="text" name="username" class="form-control" placeholder="نام کاربری" required/>
                    </div>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="گذرواژه" required/>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-default submit">ورود</button>
                    </div>

                    <div class="clearfix"></div>

                </form>
            </section>
        </div>
    </div>
</div>
</body>
<script src="/vendors/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/vendors/particles.min.js"></script>
<script type="text/javascript" src="/js/login.js"></script>
</html>
