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
            <div class="row">
                <div class="col-lg-12">
                    {{--<button type="button" class="btn btn-danger navbar-btn btn_feed_back">Feed back</button>--}}
                    <div class="panel panel-body">
                        <div class="panel-heading">Income and Expenditure details of <span class="text-uppercase text-dribbble">{{$daily_channel_name}}</span></div>
                        <div class="panel-body">
                            {!! $channel_in_ex->render() !!}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-3">Username</th>
                                    <th class="col-lg-2">Amount</th>
                                    <th class="col-lg-1">Type</th>
                                    <th class="col-lg-1">By</th>
                                    <th class="col-lg-2">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($channel_in_ex && $channel_in_ex->count())
                                    @foreach($channel_in_ex as $detail)
                                        <tr>
                                            <td>{{$detail->daily_channel_username}}</td>
                                            <td>{{$detail->amount}}$</td>
                                            <td>{{$in_expen_status[$detail->type]}}</td>
                                            <td>{{$in_exp_action[$detail->action]}}
                                                @if($detail->action==2)
                                                    <span data-container="body" data-toggle="popover"
                                                          data-placement="left" data-content="{{$detail->reason}}"
                                                          data-original-title="Reason" title=""><i
                                                                class="fa fa-question-circle"></i></span>
                                                @endif
                                            </td>
                                            <td>{{date('F Y', strtotime($detail->date))}}</td>
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