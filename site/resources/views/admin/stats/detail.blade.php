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
                            <div class="panel panel-body">
                                <div class="panel-heading">Receipts and Expenses</div>
                                <div class="panel-body">
                                    {!! Form::open(['url'=>'/adminntw/stats/detail',
                                    'method'=>'get',
                                    'name'=>'detail-stats-filter',
                                    'enctype'=>'multipart/form-data',
                                    'id'=>'detail-stats-filter-form', 'novalidate'=>'novalidate',
                                    'class'=>'']) !!}
                                    <div class="col-md-2">
                                        <div class="form-group">Month/Year
                                            <div class="input-icon right">
                                                <div class='input-group date' id='filter_month'>
                                                    <input type='text' class="form-control" name="filter[month]"
                                                           placeholder="Expected month"
                                                           value="{{isset($filter['month'])?$filter['month']:''}}"/>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <div class="form-group">Type
                                            <select class="form-control" id="filter_type"
                                                    name="filter[type]">
                                                <option value="">All</option>
                                                @foreach($in_expen_type as $k=>$v)
                                                    <option value="{{$k}}"
                                                            {{isset($filter['type']) && $filter['type']==$k?'selected':''}}
                                                            >{{$v}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">Status
                                            <select class="form-control" id="filter_status"
                                                    name="filter[status]">
                                                <option value="">All</option>
                                                @foreach($in_expen_status as $k=>$v)
                                                    <option value="{{$k}}"
                                                            {{isset($filter['status']) && $filter['status']==$k?'selected':''}}
                                                            >{{$v}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">Payment?
                                            <select class="form-control" id="filter_is_payment"
                                                    name="filter[is_payment]">
                                                <option value="">All</option>
                                                <option value="1" {{isset($filter['is_payment']) && $filter['is_payment']==1?'selected':''}}>
                                                    Payment
                                                </option>
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
                                    @include('extend.pagination_results', ['pagination'=>$receipt_expense])
                                    <div class="clearfix"></div>
                                    <hr/>
                                    {!! $receipt_expense->render() !!}
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="col-sm-1">ID</th>
                                            <th class="col-lg-2">Full Name</th>
                                            <th class="col-lg-2">Amount</th>
                                            <th class="col-lg-1">By</th>
                                            <th class="col-lg-3">Reason</th>
                                            <th class="col-lg-1">Date</th>
                                            <th class="col-lg-2">Create Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($receipt_expense && $receipt_expense->count())
                                            @foreach($receipt_expense as $detail)
                                                <tr>
                                                    <td>
                                                        <a href="{{url('adminntw/channels?filter[user_id]='.$detail->user_id)}}">
                                                            {{$detail->user_id}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{url('adminntw/channels?filter[user_id]='.$detail->user_id)}}">
                                                            {{$detail->first_name ? $detail->first_name. ' '.$detail->last_name : $detail->full_name}}
                                                        </a>
                                                    </td>
                                                    <td>{{$in_expen_type[$detail->type]}}{{$detail->amount}} {{$detail->currency_string}}</td>
                                                    <td>
                                                        {{$in_exp_action[$detail->action]}}
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
        </div>
    </div>
@stop

@section('content_script')
    <script src="/assets/admin/js/stats.js"></script>
@stop