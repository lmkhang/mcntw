@inject('admincontroller', 'App\Http\Controllers\Admin\AdminController')
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

            {{--Members List--}}
            @include('admin.members.list')
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