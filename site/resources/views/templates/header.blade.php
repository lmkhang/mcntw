<header id="header" class="header-main">

    <!-- Begin Navbar -->
    <nav id="main-navbar" class="navbar navbar-default navbar-fixed-top" role="navigation"> <!-- Classes: navbar-default, navbar-inverse, navbar-fixed-top, navbar-fixed-bottom, navbar-transparent. Note: If you use non-transparent navbar, set "height: 98px;" to #header -->

        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="/"><h2>Media Center Network</h2></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="page-scroll" href="#header">Home</a></li>
                    <li><a class="page-scroll" href="#about-section">About</a></li>
                    <li><a class="page-scroll" href="#services-section">Services</a></li>
                    <li><a class="page-scroll" href="#social-section">Social Network</a></li>
                    <li><a class="page-scroll" href="#faq-section">FAQ</a></li>
                    <li><a class="page-scroll" href="#contact-section">Contact</a></li>
                    @if($joinus['logged']==false)
                        <li><a class="joinus" href="#">Login</a></li>
                    @else
                        <li><a class="" href="{{url('dashboard')}}">Dashboard</a></li>
                        <li><a class="" href="{{$joinus['url_logout']}}">Logout</a></li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
    <!-- End Navbar -->

</header>