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
            <div id="sum_box" class="row mbl">
                <div class="col-sm-6 col-md-3">
                    <div class="panel income db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-money"></i>
                            </p>
                            <h4 class="value">
                                <span></span><span>$</span>
                            </h4>

                            <p class="description">
                                Income detail</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="panel profit db mbm">
                        <div class="panel-body">
                            <p class="icon">
                                <i class="icon fa fa-shopping-cart"></i>
                            </p>
                            <h4 class="value">
                                {{$minpay}}$
                            </h4>

                            <p class="description">
                                Min PAY</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{--<button type="button" class="btn btn-danger navbar-btn btn_feed_back">Feed back</button>--}}
                    <div class="panel panel-body">
                        <div class="panel-heading">Income and Expenditure details of <span class="text-uppercase text-dribbble">{{$name}}</span></div>
                        <div class="panel-body">
                            @include('extend.pagination_results', ['pagination'=>$user_in_ex])
                            {!! $user_in_ex->render() !!}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-2">Amount</th>
                                    <th class="col-lg-1">By</th>
                                    <th class="col-lg-3">Reason</th>
                                    <th class="col-lg-2">Date</th>
                                    <th class="col-lg-2">Create Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($user_in_ex && $user_in_ex->count())
                                    @foreach($user_in_ex as $detail)
                                        <tr>
                                            <td>{{$in_expen_status[$detail->type]}}{{$detail->amount}} {{$detail->currency_string}}</td>
                                            <td>{{$in_exp_action[$detail->action]}}
                                            </td>
                                            <td>{{$detail->reason}}</td>
                                            <td>{{date('F Y', strtotime($detail->date))}}</td>
                                            <td>{{$detail->created_at}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-danger">No record</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop

@section('content_script')
    <script>
        var total = '{{$user_stats['total']}}';
        var start = Math.floor(total / 1.5);
        //BEGIN COUNTER FOR SUMMARY BOX
        counterNum($(".income h4 span:first-child"), start, total, 1, 50);
        function counterNum(obj, start, end, step, duration) {
            $(obj).html(start);
            setInterval(function () {
                var val = Number($(obj).html());
                if (val < end) {
                    $(obj).html(val + step);
                } else {
                    //revert precise
                    if (Number($(".income h4 span:first-child").html()) > total) {
                        $(obj).html(total);
                    }
                    clearInterval();
                }
            }, duration);
        }
        //END COUNTER FOR SUMMARY BOX
    </script>
@stop