<section id="faq-section" class="page text-center">
    <!-- Begin page header-->
    <div class="page-header-wrapper">
        <div class="container">
            <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                <h2>Frequently asked questions (FAQ)</h2>

                {{--<div class="devider"></div>--}}
                {{--<p class="subtitle">what we really know how</p>--}}
            </div>
        </div>
    </div>
    <!-- End page header-->

    <!-- Begin roatet box-2 -->
    <div class="rotate-box-2-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="rotate-box-2 square-icon text-left wow zoomIn" data-wow-delay="0">
                        @foreach($faq as $f)
                            <div class="rotate-box-info">
                                <h4>{{$f['number']}}/ {{$f['question']}}</h4>

                                <p>
                                    {{$f['answer']}}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

    </div>
    <!-- End rotate-box-2 -->
</section>