<div class="row">
    <div class="col-lg-12">
        {{--<button type="button" class="btn btn-danger navbar-btn btn_feed_back">Feed back</button>--}}
        <div class="panel panel-body">
            <div class="panel-heading">User list</div>
            <div class="panel-body">
                {!! Form::open(['url'=>'/adminntw/members',
                'method'=>'get',
                'name'=>'members-filter',
                'enctype'=>'multipart/form-data',
                'id'=>'members-filter-form', 'novalidate'=>'novalidate',
                'class'=>'']) !!}
                <div class="col-md-2">
                    <div class="form-group">Name
                        <input name="filter[full_name]" id="full_name"
                               class="form-control" type="text"
                               value="{{isset($filter['full_name']) ?$filter['full_name']:''}}"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">Amount ($)
                        <input name="filter[amount]" id="amount"
                               class="form-control" type="number"
                               value="{{isset($filter['amount']) ?$filter['amount']:''}}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
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
                @include('extend.pagination_results', ['pagination'=>$user_in_ex])
                <div class="clearfix"></div>
                <hr/>
                {!! $user_in_ex->render() !!}
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="">ID</th>
                        <th class="col-lg-2">Full Name</th>
                        <th class="col-lg-1">Contract Email</th>
                        <th class="col-lg-3">Payment Information</th>
                        <th class="col-lg-1">Amount</th>
                        <th class="col-lg-1">Last Income</th>
                        <th class="col-lg-1">Action</th>
                        <th class="col-lg-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user_in_ex && $user_in_ex->count())
                        @foreach($user_in_ex as $detail)
                            <tr class="tr_{{$detail->user_id}}">
                                <td>{{$detail->user_id}}</td>
                                <td>
                                    <a href="{{url('adminntw/channels?filter[user_id]='.$detail->user_id)}}">
                                        {{$detail->first_name ? $detail->first_name. ' '.$detail->last_name : $detail->full_name}}
                                    </a>
                                </td>
                                <td class="">
                                    {{$detail->payment_email}}
                                </td>
                                <td>
                                    <?php $info = $admincontroller->createPaymentInfo($detail); ?>
                                    {!! nl2br($info['info']) !!}
                                </td>
                                <td class="td_amount_{{$detail->user_id}}">{{$detail->total}}$</td>
                                <td class="td_last_income_{{$detail->user_id}}">{{date('Y-m-d H:i:s', strtotime($detail->updated_at))}}</td>
                                <td>
                                    @include('admin.members.adjust', ['user_id'=> $detail->user_id, 'total'=>$detail->total, 'payment_method'=>$info['payment_method'] ])
                                </td>
                                <td>
                                    <button type="button" class="btn btn-google-plus btn-sm"
{{--                                            onclick="window.location='{{url('/adminntw/members/'.$detail->user_id.'/detail')}}'"--}}
                                            onclick="window.location='{{url('adminntw/stats/detail?filter[user_id]='.$detail->user_id)}}'"
                                            >
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