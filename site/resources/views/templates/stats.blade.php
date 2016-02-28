<section id="cta-section">
    <div class="cta">
        <div class="container">
            <div class="row">
                @foreach($stats_show as $stat)
                    <div class="col-md-3">
                        <div class="cta-btn wow bounceInRight" data-wow-delay="0.4s">
                            <div class="rotate-box-info">
                                <h1>{{$stat['title']}}</h1>

                                <p>

                                <h3><i>{{$stat['value']}}</i></h3>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
</section>