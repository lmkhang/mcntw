<section id="contact-section" class="page text-white parallax" data-stellar-background-ratio="0.5"
         style="background-image: url({{URL::asset('assets/img/map-bg.jpg')}});">
    <div class="cover"></div>

    <!-- Begin page header-->
    <div class="page-header-wrapper">
        <div class="container">
            <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                <h2>Contacts</h2>

                <div class="devider"></div>
                <p class="subtitle">All to contact us</p>
            </div>
        </div>
    </div>
    <!-- End page header-->

    <div class="contact wow bounceInRight" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">

                <div class="col-sm-6">
                    <div class="contact-info">
                        <h4>Our Address</h4>
                        <ul class="contact-address">
                            <li><i class="fa fa-envelope"></i> contact@mcenterntw.com</li>
                            <li><i class="fa fa-skype"></i> Media Center Network</li>
                            <li><img src="{{URL::asset('assets/img/logo/logo_200x200.png')}}" border="0"></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="contact-form">
                        <h4>Write to us</h4>

                        {!! Form::open(['url'=>'/sendmail', 'method'=>'post']) !!}
                            <div class="form-group">
                                <input type="text" name="mail[full_name]" class="form-control input-lg" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="mail[email]" class="form-control input-lg" placeholder="E-mail" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="mail[subject]" class="form-control input-lg" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea name="mail[message]" class="form-control input-lg" rows="5" placeholder="Message"
                                          required></textarea>
                            </div>
                            <button type="submit" class="btn wow bounceInRight" data-wow-delay="0.8s">Send</button>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
</section>