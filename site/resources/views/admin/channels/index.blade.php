@extends('admin.templates.master')

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
                            <button type="button" class="btn btn-danger navbar-btn"
                                    onclick="window.location='{{url('/adminntw/stats')}}'">Import Data (CSV)
                            </button>
                            <div class="panel panel-body">
                                <div class="panel-heading">All Channels @yield('of_someone')</div>
                                <div class="panel-body">
                                    {!! Form::open(['url'=>'/adminntw/channels',
                                    'method'=>'get',
                                    'name'=>'channel-filter',
                                    'enctype'=>'multipart/form-data',
                                    'id'=>'channel-filter-form', 'novalidate'=>'novalidate',
                                    'class'=>'']) !!}
                                    <div class="col-md-2">
                                        <div class="form-group">User
                                            <select class="form-control" id="filter_user_id"
                                                    name="filter[user_id]">
                                                <option value="">All</option>
                                                @foreach($users as $u)
                                                    <option value="{{$u->user_id}}"
                                                            {{isset($filter['user_id']) && $filter['user_id']==$u->user_id?'selected':''}}>
                                                        [ID: {{$u->user_id}}
                                                        ] {{$u->first_name ? $u->first_name. ' '.$u->last_name : $u->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">Status
                                            <select class="form-control" id="filter_status"
                                                    name="filter[status]">
                                                <option value="">All</option>
                                                @foreach($channel_status as $k=>$v)
                                                    <option value="{{$k}}"
                                                            {{isset($filter['status']) && $filter['status']==$k?'selected':''}}
                                                            >{{$channel_status[$k]}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">&nbsp;
                                            <button type="submit" class="btn btn-primary btn_filter form-control">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                    <div class="clearfix"></div>
                                    <hr/>
                                    @include('extend.pagination_results', ['pagination'=>$channels_paging])
                                    <div class="clearfix"></div>
                                    <hr/>
                                    {!! $channels_paging->render() !!}
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="col-lg-2">Username</th>
                                            <th class="col-lg-2">Screen Name</th>
                                            <th class="col-lg-3">Email</th>
                                            <th class="col-lg-2">Create Date</th>
                                            <th class="col-lg-2">Status</th>
                                            <th class="col-lg-1">Action</th>
                                            <th class="col-lg-1"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($channels_paging && $channels_paging->count())
                                            @foreach($channels_paging as $channel)
                                                <tr title="{{$channel->status==4?'All payment for this channel wil not be updated due violating dailymotion rules.':''}}">
                                                    <td>
                                                        <a href="{{str_replace(array('{channel_name}'), array($channel->daily_channel_username), $url_stats)}}"
                                                           target="_blank">
                                                            {{$channel->daily_channel_username}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{str_replace(array('{channel_name}'), array($channel->daily_channel_username), $url_stats)}}"
                                                           target="_blank">
                                                            {{$channel->daily_channel_name}}
                                                        </a>
                                                    </td>
                                                    <td>{{$channel->email}}</td>
                                                    <td>{{date('l jS \of F Y', strtotime($channel->created_at))}}</td>
                                                    <td>
                                                        <span class="label label-sm {{$channel_label_status[$channel->status]}}">
                                                            {{$channel_status[$channel->status]}}
                                                        </span>
                                                        <br/>
                                                        {{$channel->status==1?'('.$channel->approved_at.')':''}}
                                                    </td>
                                                    <td>
                                                        <div class="input-group-btn">
                                                            <button type="button" data-toggle="dropdown"
                                                                    class="btn btn-default dropdown-toggle">Action
                                                                &nbsp;<span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                @foreach($channel_status as $k=>$c_status)
                                                                    <li>
                                                                        <a href="#"
                                                                           onclick="changeStatus(this); return false;"
                                                                           data-status="{{$k}}"
                                                                           data-change-id="{{$channel->channel_id}}"
                                                                           data-action="{{ $k!=$channel->status?true:false}}">{{$c_status}}</a>
                                                                    </li>
                                                                @endforeach
                                                                <li>
                                                                    <a href="#"
                                                                       onclick="decline(this); return false;"
                                                                       data-channel-id="{{$channel->channel_id}}">Decline</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-google-plus btn-sm"
                                                                onclick="window.location='{{url('/adminntw/channels/'.$channel->daily_channel_id.'/detail')}}'">
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
        </div>
    </div>
@stop

@section('content_script')
    <script>
        var date = '{{date('Y-m-d')}}';
    </script>
    <script src="/assets/admin/js/channels.js"></script>
@stop