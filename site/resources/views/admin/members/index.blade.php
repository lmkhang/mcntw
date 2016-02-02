@inject('admincontroller', 'App\Http\Controllers\Admin\AdminController')
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
                        <div class="panel-heading">User list</div>
                        <div class="panel-body">
                            {!! $user_in_ex->render() !!}
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-2">Full Name</th>
                                    <th class="col-lg-4">Payment Information</th>
                                    <th class="col-lg-1">Amount</th>
                                    <th class="col-lg-2">Last Income</th>
                                    <th class="col-lg-2">Action</th>
                                    <th class="col-lg-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($user_in_ex && $user_in_ex->count())
                                    @foreach($user_in_ex as $detail)
                                        <tr class="tr_{{$detail->user_id}}">
                                            <td>{{$detail->full_name ? $detail->full_name:$detail->first_name. ' '.$detail->last_name}}</td>
                                            <td>
                                                <?php $info = $admincontroller->createPaymentInfo($detail); ?>
                                                {!! nl2br($info['info']) !!}
                                            </td>
                                            <td class="td_amount_{{$detail->user_id}}">{{$detail->total}}$</td>
                                            <td class="td_last_income_{{$detail->user_id}}">{{date('Y-m-d H:i:s', strtotime($detail->updated_at))}}</td>
                                            <td>
                                                @include('admin.members.adjust', ['user_id'=> $detail->user_id, 'total'=>$detail->total ])
                                            </td>
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
    <script src="/assets/admin/js/members.js"></script>
@stop