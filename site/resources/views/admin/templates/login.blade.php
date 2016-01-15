<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/animate.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/all.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/main.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/style-responsive.css">
</head>
<body style="background: url('/assets/dashboard/images/bg/bg.png') center center fixed; height: auto;">
<div class="page-form">
    <div class="panel panel-blue">
        <div class="panel-body pan">
            {!! Form::open(['url'=>'/adminntw/login',
            'method'=>'post',
            'name'=>'login-admin',
            'id'=>'login-admin-form', 'novalidate'=>'novalidate',
            'class'=>'form-horizontal']) !!}
            <div class="form-body pal">
                <div class="col-md-12 text-center">
                    <h1 style="margin-top: -90px; font-size: 48px;">
                        MCenterNTW Admin</h1>
                    <br/>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                        <img src="/assets/dashboard/images/avatar/profile-pic.png" class="img-responsive"
                             style="margin-top: -35px;"/>
                    </div>
                    <div class="col-md-9 text-center">
                        <h1>
                            Hold on, please.</h1>
                        <br/>

                        <p>
                            Just sign in and we’ll send you on your way</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-md-3 control-label">
                        Username or Email:</label>

                    <div class="col-md-9">
                        <div class="input-icon right">
                            <i class="fa fa-user"></i>
                            <input id="user-name-email" autocomplete="off"
                                   placeholder="Username or Email"
                                   type="text" name="login[account]"
                                   size="100" class="form-control"/></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-md-3 control-label">
                        Password:</label>

                    <div class="col-md-9">
                        <div class="input-icon right">
                            <i class="fa fa-lock"></i>
                            <input maxlength="255" id="user-password"
                                   placeholder="Password" type="password" name="login[password]" size="50" class="form-control"/></div>
                    </div>
                </div>
                <div class="form-group mbn">
                    <div class="col-lg-12" align="right">
                        <div class="form-group mbn">
                            <div class="col-lg-3">
                                &nbsp;
                            </div>
                            <div class="col-lg-9">
                                <label class="text-warning common_message">
                                </label>
                                <a href="{{route('home_page')}}" class="btn btn-default">Home</a>&nbsp;&nbsp;
                                <button type="submit" class="btn btn-green btn_login_admin">
                                    Sign In
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script src="/assets/dashboard/script/jquery-1.10.2.min.js"></script>
<!-- Form validation -->
<script src="{{URL::asset('assets/js/lib/jquery.mockjax.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.form.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.validate.js')}}"></script>

<script src="{{URL::asset('assets/admin/js/login.js')}}"></script>
</body>
</html>
