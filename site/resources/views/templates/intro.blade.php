<section id="text-carousel-intro-section" class="parallax" data-stellar-background-ratio="0.5"
         style="background-image: url({{URL::asset('assets/img/slider-bg.jpg')}});">

    <div class="container">
        <div class="caption text-center text-white" data-stellar-ratio="0.7" style="top: 200px;">

            <div id="owl-intro-text" class="owl-carousel">
                <div class="item">
                    @if($joinus['logged']==false)
                    <a class="joinus btn btn-info" href="#"><h1>Join with us</h1></a>
                    @else
                        <a class="btn btn-info" href="{{url('dashboard')}}"><h1>My Dashboard</h1></a>
                    @endif


                    {{--<p>To the greatest Journey</p>--}}

                    {{--<div class="extra-space-l"></div>--}}

                    {{--@if($joinus['logged']==false)--}}
                    {{--<a class="btn btn-blank" href="{{$joinus['url_join']}}" target="_top"--}}
                       {{--role="button">View More!</a>--}}
                    {{--@endif--}}
                </div>
                {{--<div class="item">--}}
                    {{--<h1>We have Awesome things</h1>--}}

                    {{--<p>Let's make the web beautiful together</p>--}}

                    {{--<div class="extra-space-l"></div>--}}
                    {{--<a class="btn btn-blank" href="https://creativemarket.com/Themetorium" target="_blank"--}}
                       {{--role="button">View More!</a>--}}
                {{--</div>--}}
                {{--<div class="item">--}}
                    {{--<h1>I'm Unika</h1>--}}

                    {{--<p>One Page Responsive Theme</p>--}}

                    {{--<div class="extra-space-l"></div>--}}
                    {{--<a class="btn btn-blank" href="https://creativemarket.com/Themetorium" target="_blank"--}}
                       {{--role="button">View More!</a>--}}
                {{--</div>--}}
            </div>

        </div>
        <!-- /.caption -->
    </div>
    <!-- /.container -->

</section>