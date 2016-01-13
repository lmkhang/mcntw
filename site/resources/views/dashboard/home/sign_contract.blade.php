@extends('dashboard.templates.master')

@section('title')
    {{$page_title}}
@stop
@section('full_name')
    {{$name}}
@stop
@section('content')
    <div class="page-content">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">
                    <div class="col-md-12">
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-orange">
                                <div class="panel-heading">
                                    {{$page_title}}
                                </div>
                                <div class="panel-body pan">
                                    {!! Form::open(['url'=>'/dashboard/sign_contract/send', 'method'=>'post',
                                    'name'=>'sign_contract',
                                    'id'=>'sign-contract-form', 'novalidate'=>'novalidate']) !!}
                                    <div class="form-body pal">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <i class="fa fa-envelope"></i>
                                                <input value="{{$user['payment_email']}}" id="sign_contract-email" type="email" placeholder="Payment Email address"
                                                       class="form-control" name="sign_contract[email]"/></div>
                                        </div>
                                        <hr/>
                                        <div class="form-group mbn">
                                            <div class="checkbox">
                                                    <input tabindex="5" type="checkbox" id="sign_contract-agree"
                                                           name="sign_contract[agree]"/>&nbsp; <a
                                                            href="{{url($contract_file)}}"
                                                            target="_blank">Click here to read our payment policy</a></div>
                                        </div>
                                    </div>
                                    <div class="form-actions pal">
                                        <button type="submit" name="commit" class="btn btn-primary btn_sign_contract">
                                            Sign
                                        </button>
                                        <label class="text-warning common_message">
                                        </label>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('content_script')
    <script src="/assets/dashboard/js/sign_contract.js"></script>
@stop
