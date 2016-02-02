@extends('admin.templates.master')

@section('title')
    {{$page_title}}
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
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{--<button type="button" class="btn btn-danger navbar-btn btn_feed_back">Feed back</button>--}}
                    <div class="panel panel-body">
                        <div class="panel-heading">User list</div>
                        <div class="panel-body">
                            {!! $user_in_ex->render() !!}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-3">Full Name</th>
                                    <th class="col-lg-4">Payment Email</th>
                                    <th class="col-lg-3">Amount</th>
                                    <th class="col-lg-2">Last Income</th>
                                    <th class="col-lg-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($user_in_ex && $user_in_ex->count())
                                    @foreach($user_in_ex as $detail)
                                        <tr>
                                            <td>{{$detail->full_name ? $detail->full_name:$detail->first_name. ' '.$detail->last_name}}</td>
                                            <td>{{$detail->payment_email}}</td>
                                            <td>{{$detail->total}}$</td>
                                            <td>{{date('F Y', strtotime($detail->updated_at))}}</td>
                                            <td>
                                                <button type="button" class="btn btn-google-plus btn-sm"
                                                        onclick="window.location='{{url('/adminntw/members/'.$detail->user_id.'/detail')}}'">
                                                    Detail
                                                </button>
                                            </td>
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
        var total = '{{$total_income}}';
        var start = Math.floor(total / 1.2);
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