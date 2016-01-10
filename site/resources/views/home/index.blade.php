@extends('templates.master', ['joinus'=> $joinus, 'site'=>$site ])

@section('title', 'Home')

@section('content')
    <!-- Begin text carousel intro section -->
    @include('templates.intro', ['joinus'=>$joinus])
    <!-- End text carousel intro section -->


    <!-- Begin about section -->
    @include('templates.about')
    <!-- End about section -->


    <!-- Begin cta -->
    @include('templates.term')
    <!-- End cta -->


    <!-- Begin Services -->
    @include('templates.services')
    <!-- End Services -->


    <!-- Begin testimonials -->
    {{--@include('templates.reviewtous')--}}
    <!-- End testimonials -->


    <!-- Begin Portfolio -->

    <!-- End portfolio -->


    <!-- Begin counter up -->
    {{--@include('templates.counter')--}}
    <!-- End counter up -->


    <!-- Begin team-->
    {{--@include('templates.ourteam')--}}
    <!-- End team-->


    <!-- Begin partners -->
    {{--@include('templates.partners')--}}
    <!-- End partners -->


    <!-- Begin prices section -->

    <!-- End prices section -->


    <!-- Begin social section -->
    @include('templates.socialntw', ['socialntw' => $socialntw])
    <!-- End social section -->


    <!-- Begin contact section -->
    @include('templates.contact', ['socialntw' => $socialntw])
    <!-- End contact section -->
@stop