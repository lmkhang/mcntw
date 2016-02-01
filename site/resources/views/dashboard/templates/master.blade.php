@inject('controller', 'App\Http\Controllers\Controller')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - @yield('full_name') - MCenterNTW Dashboard</title>
    {{--<meta name="description" content="{{ $site['description'] }}">--}}
    {{--<meta name="keywords" content="{{ $site['keywords'] }}"/>--}}
    {{--<meta name="author" content="{{ $site['urlhome'] }}">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/logo/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/img/logo/favicon.png">
    <link rel="shortcut icon" type="image/png" href="/assets/img/logo/favicon.png"/>
    {{--<link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">--}}
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/animate.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/all.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/main.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/pace.css">
    <link type="text/css" rel="stylesheet" href="/assets/dashboard/styles/jquery.news-ticker.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">

    <!--Popup base on bootstrap-->
    <link type="text/css" rel="stylesheet" href="/assets/css/lib/bootstrap-dialog.min.css">

</head>
<body>
<div>
    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <!--END BACK TO TOP-->
    <!--BEGIN TOPBAR-->
    @include('dashboard.templates.header')
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN SIDEBAR MENU-->
        @include('dashboard.templates.menu')
        <!--END SIDEBAR MENU-->
        <!--BEGIN CHAT FORM-->
        {{--@include('dashboard.templates.chatbar')--}}
        <!--END CHAT FORM-->
        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
            @include('dashboard.templates.navbar')
            <!--END TITLE & BREADCRUMB PAGE-->
            <!--BEGIN CONTENT-->
            @yield('content')
            {{--It is hard to know--}}
            <div class="hidden">
                <div id="area-chart-spline" style="width: 100%; height: 300px">
                </div>
            </div>
            {{--It is hard to know--}}
            <!--END CONTENT-->
            <!--BEGIN FOOTER-->
            @include('dashboard.templates.footer')
            <!--END FOOTER-->
        </div>
        <!--END PAGE WRAPPER-->
    </div>
</div>
<script src="/assets/dashboard/script/jquery-1.10.2.min.js"></script>
<script src="/assets/dashboard/script/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/dashboard/script/jquery-ui.js"></script>
<script src="/assets/dashboard/script/bootstrap.min.js"></script>
<script src="/assets/dashboard/script/bootstrap-hover-dropdown.js"></script>
<script src="/assets/dashboard/script/html5shiv.js"></script>
<script src="/assets/dashboard/script/respond.min.js"></script>
<script src="/assets/dashboard/script/jquery.metisMenu.js"></script>
<script src="/assets/dashboard/script/jquery.slimscroll.js"></script>
<script src="/assets/dashboard/script/jquery.cookie.js"></script>
<script src="/assets/dashboard/script/icheck.min.js"></script>
<script src="/assets/dashboard/script/custom.min.js"></script>
<script src="/assets/dashboard/script/jquery.news-ticker.js"></script>
<script src="/assets/dashboard/script/jquery.menu.js"></script>
<script src="/assets/dashboard/script/pace.min.js"></script>
<script src="/assets/dashboard/script/holder.js"></script>
<script src="/assets/dashboard/script/responsive-tabs.js"></script>
<script src="/assets/dashboard/script/jquery.flot.js"></script>
<script src="/assets/dashboard/script/jquery.flot.categories.js"></script>
<script src="/assets/dashboard/script/jquery.flot.pie.js"></script>
<script src="/assets/dashboard/script/jquery.flot.tooltip.js"></script>
<script src="/assets/dashboard/script/jquery.flot.resize.js"></script>
<script src="/assets/dashboard/script/jquery.flot.fillbetween.js"></script>
<script src="/assets/dashboard/script/jquery.flot.stack.js"></script>
<script src="/assets/dashboard/script/jquery.flot.spline.js"></script>
<script src="/assets/dashboard/script/zabuto_calendar.min.js"></script>
<script src="/assets/dashboard/script/index.js"></script>
<!--LOADING SCRIPTS FOR CHARTS-->
<script src="/assets/dashboard/script/highcharts.js"></script>
<script src="/assets/dashboard/script/data.js"></script>
<script src="/assets/dashboard/script/drilldown.js"></script>
<script src="/assets/dashboard/script/exporting.js"></script>
<script src="/assets/dashboard/script/highcharts-more.js"></script>
<script src="/assets/dashboard/script/charts-highchart-pie.js"></script>
<script src="/assets/dashboard/script/charts-highchart-more.js"></script>
<!-- Form validation -->
<script src="{{URL::asset('assets/js/lib/jquery.mockjax.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.form.js')}}"></script>
<script src="{{URL::asset('assets/js/lib/jquery.validate.js')}}"></script>

<!--CORE JAVASCRIPT-->
<script src="/assets/dashboard/script/main.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="/assets/js/lib/bootstrap-select.min.js"></script>

<!--Notice-->
{{--<script src="{{URL::asset('assets/js/lib/notie.js')}}"></script>--}}

<!--Popup base on bootstrap-->
<script src="{{URL::asset('assets/js/lib/bootstrap-dialog.min.js')}}"></script>

@if($controller->hasFlash('message'))
    <script>
        {{--notie.alert(4, '{{$controller->getFlash('message')}}', 4);--}}
        BootstrapDialog.show({
            title: 'Notice',
            message: '{{$controller->getFlash('message')}}'
        });
    </script>
@endif

@yield('content_script')
@include('admin.templates.modal_dialog')
</body>
</html>
