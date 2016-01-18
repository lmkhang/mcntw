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
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-danger navbar-btn btn_new_channel">New Channel</button>
                            <div class="panel panel-body">
                                <div class="panel-heading">Channels of {{$name}}</div>
                                <div class="panel-body">
                                    {!! $channels_paging->render() !!}
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="col-lg-2">Username</th>
                                            <th class="col-lg-2">Screen Name</th>
                                            <th class="col-lg-3">Email</th>
                                            <th class="col-lg-2">Create Date</th>
                                            <th class="col-lg-2">Status</th>
                                            <th class="col-lg-1"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($channels_paging && $channels_paging->count())
                                            @foreach($channels_paging as $channel)
                                                <tr>
                                                    <td>{{$channel->daily_channel_username}}</td>
                                                    <td>{{$channel->daily_channel_name}}</td>
                                                    <td>{{$channel->email}}</td>
                                                    <td>{{date('l jS \of F Y', strtotime($channel->created_at))}}</td>
                                                    <td>
                                                        <span class="label label-sm {{$channel_label_status[$channel->status]}}">{{$channel_status[$channel->status]}}</span>
                                                        <br/>
                                                        {{$channel->approved_at?'('.$channel->approved_at.')':''}}
                                                    </td>
                                                    <td>
                                                        @if($channel->status==1)
                                                            <button type="button" class="btn btn-google-plus btn-sm">
                                                                Access
                                                            </button>
                                                        @endif
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
                                    {!! $channels_paging->render() !!}
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
    <script>
        var url_oauth = '{{$daily['url_oauth']}}';
    </script>

    <script src="/assets/dashboard/js/channels.js"></script>
@stop