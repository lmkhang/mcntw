<!doctype html>
<html lang="en-US">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Media Center Network - @yield('title')</title>
    <meta name="description" content="{{ $site['description'] }}">
    <meta name="keywords" content="{{ $site['keywords'] }}"/>
    <meta name="author" content="{{ $site['urlhome'] }}">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--Favico--}}
    <link rel="shortcut icon" href="/assets/img/logo/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/img/logo/favicon.png">
    <link rel="shortcut icon" type="image/png" href="/assets/img/logo/favicon.png"/>
    <!-- Google Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
    <!-- Body font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <!-- Navbar font -->

    <!-- Libs and Plugins CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/inc/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/inc/animations/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/inc/font-awesome/css/font-awesome.min.css')}}">
    <!-- Font Icons -->
    <link rel="stylesheet" href="{{URL::asset('assets/inc/owl-carousel/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/inc/owl-carousel/css/owl.theme.css')}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/reset.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/mobile.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/us_normalize.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/us_style.css')}}">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/skin/cool-gray.css')}}">
    <!-- <link rel="stylesheet" href="css/skin/ice-blue.css"> -->
    <!-- <link rel="stylesheet" href="css/skin/summer-orange.css"> -->
    <!-- <link rel="stylesheet" href="css/skin/fresh-lime.css"> -->
    <!-- <link rel="stylesheet" href="css/skin/night-purple.css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!-- Virtual Keyboard -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/jquery.numpad.css')}}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-spy="scroll" data-target="#main-navbar">
<div class="page-loader"></div>
<!-- Display loading image while page loads -->
<div class="body">

    <!--========== BEGIN HEADER ==========-->
    @include('templates.header', ['joinus'=>$joinus])
    <!-- ========= END HEADER =========-->

    @yield('content')

    <!-- Begin footer -->
    @include('templates.footer')
    <!-- End footer -->

    <a href="#" class="scrolltotop"><i class="fa fa-arrow-up"></i></a> <!-- Scroll to top button -->

</div>
<!-- body ends -->


<!-- Modal -->
@include('user.reg_log', ['refer'=>$site['refer'], 'daily'=>$daily, 'fbook'=>$fbook, 'google'=>$google])
<!-- End Modal -->

<!-- Plugins JS -->
<script src="{{URL::asset('assets/inc/jquery/jquery-1.11.1.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/owl-carousel/js/owl.carousel.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/stellar/js/jquery.stellar.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/animations/js/wow.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/waypoints.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/isotope.pkgd.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/classie.js')}}"></script>
<script src="{{URL::asset('assets/inc/jquery.easing.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/jquery.counterup.min.js')}}"></script>
<script src="{{URL::asset('assets/inc/smoothscroll.js')}}"></script>

<!-- Form validation -->
<script src="{{URL::asset('assets/js/lib/jquery.mockjax.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.form.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.validate.js')}}"></script>

<!-- Theme JS -->
<script src="{{URL::asset('assets/js/theme.js')}}"></script>
<script src="{{URL::asset('assets/js/events.js')}}"></script>
<script src="{{URL::asset('assets/js/us_index.js')}}"></script>

<!-- Virtual Keyboard -->
<script src="{{URL::asset('assets/js/jquery.numpad.js')}}"></script>

<!--Notice-->
<script src="{{URL::asset('assets/js/lib/notie.js')}}"></script>

@if($site['message'])
    <script>
        notie.alert(4, '{{$site['message']}}', 4);
    </script>
@endif
            <!--Notice Template-->
    {{--@include('templates.notice')--}}
    <!--End Notice Template-->

</body>


</html>
