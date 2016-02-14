@inject('admincontroller', 'App\Http\Controllers\Admin\AdminController')
@extends('admin.templates.master')

@section('title')
    {{$page_title}}
@stop

@section('content')
    <div class="page-content">
        <div id="tab-general">
            <div id="sum_box" class="row mbl">
                <div class="col-sm-6 col-md-4">
                    <div class="panel paid_amount db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span>

                                </span>
                                <span>$</span>
                            </h4>
                            <p class="description">
                                Total Paid Amount </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="panel net_mount_ db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span></span><span>$</span>
                            </h4>

                            <p class="description">
                                Net Total Amount</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="panel pay_amount db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span></span><span>$</span>
                            </h4>

                            <p class="description">
                                Going to pay</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="panel hold_amount db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span></span><span>$</span>
                            </h4>

                            <p class="description">
                                Hold</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="panel blocked_mount db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span></span><span>$</span>
                            </h4>

                            <p class="description">
                                Blocked amount</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-green btn-block btn_update" onclick="window.location='{{url('/adminntw/stats/update')}}'">
                        Update Statistics
                    </button>
                </div>
            </div>

            {{--Members List--}}
            @include('admin.members.list')
        </div>
    </div>
@stop

@section('content_script')
    <script>
        var tax_pay_bank = '{{$tax_pay_bank}}';
        var currency = '{{$currency}}';

{{--        var gross_amount = '{{$home['gross_amount']}}';--}}
        var paid_amount = '{{$home['paid_amount']}}';
        var net_mount_ = '{{$home['net_mount']}}';
        var pay_amount = '{{$home['pay_amount']}}';
        var blocked_mount = '{{$home['blocked_mount']}}';
        var hold_amount = '{{$home['hold_amount']}}';
//        var start_gross_amount = Math.floor(gross_amount / 1.2);
        var start_paid_amount = Math.floor(paid_amount / 1.2);
        var start_net_amount = Math.floor(net_mount_ / 1.2);
        var start_pay_amount = Math.floor(pay_amount / 1.2);
        var start_blocked_mount = Math.floor(blocked_mount / 1.2);
        var start_hold_amount = Math.floor(hold_amount / 1.2);
        //BEGIN COUNTER FOR SUMMARY BOX
//        counterNum($(".gross_amount h4 span:first-child"), start_gross_amount, gross_amount, 1, 50);
        counterNum($(".paid_amount h4 span:first-child"), start_paid_amount, paid_amount, 1, 50);
        counterNum($(".net_mount_ h4 span:first-child"), start_net_amount, net_mount_, 1, 50);
        counterNum($(".pay_amount h4 span:first-child"), start_pay_amount, pay_amount, 1, 50);
        counterNum($(".blocked_mount h4 span:first-child"), start_blocked_mount, blocked_mount, 1, 50);
        counterNum($(".hold_amount h4 span:first-child"), start_hold_amount, hold_amount, 1, 50);
        function counterNum(obj, start, end, step, duration) {
            $(obj).html(start);
            setInterval(function () {
                var val = Number($(obj).html());
                if (val < end) {
                    $(obj).html(val + step);
                } else {
                    //revert precise
                    if (Number($(obj).html()) > end) {
                        $(obj).html(end);
                    }
                    clearInterval();
                }
            }, duration);
        }
        //END COUNTER FOR SUMMARY BOX
    </script>
    <script src="/assets/admin/js/members.js"></script>
@stop