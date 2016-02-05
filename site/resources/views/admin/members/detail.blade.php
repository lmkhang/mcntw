@extends('admin.templates.master')

@section('title')
    {{$page_title}}
@stop

@section('content')
    <div class="page-content">
        <div id="tab-general">
            <div class="row">
                <div class="col-lg-12">
                    {{--<button type="button" class="btn btn-danger navbar-btn btn_feed_back">Feed back</button>--}}
                    <div class="panel panel-body">
                        <div class="panel-heading">Income and Expenditure details of <span
                                    class="text-uppercase text-dribbble">{{$name}}</span></div>
                        <div class="panel-body">
                            {!! $user_in_ex->render() !!}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-2">Amount</th>
                                    <th class="col-lg-1">By</th>
                                    <th class="col-lg-2">Reason</th>
                                    <th class="col-lg-1">Date</th>
                                    <th class="col-lg-2">Create Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($user_in_ex && $user_in_ex->count())
                                    @foreach($user_in_ex as $detail)
                                        <tr>
                                            <td>{{$in_expen_status[$detail->type]}}{{$detail->amount}} {{$detail->currency_string}}</td>
                                            <td>{{$in_exp_action[$detail->action]}}
                                                {{--@if($detail->action==2)--}}
                                                {{--<span data-container="body" data-toggle="popover"--}}
                                                {{--data-placement="left" data-content="{{$detail->reason}}"--}}
                                                {{--data-original-title="Reason" title=""><i--}}
                                                {{--class="fa fa-question-circle"></i></span>--}}
                                                {{--@endif--}}
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

@stop