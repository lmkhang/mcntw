@extends('admin.templates.master')

@section('title')
    {{$page_title}}
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
                        <div class="col-md-12">

                            <div class="row mtl">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="text-center mbl"><img
                                                    src="{{$admin['gavatar']}}" alt=""
                                                    class="img-responsive"/></div>
                                        {{--<div class="text-center mbl"><a href="#" class="btn btn-green"><i--}}
                                        {{--class="fa fa-upload"></i>&nbsp;--}}
                                        {{--Upload</a></div>--}}
                                    </div>
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <td>User Name</td>
                                            <td>{{$admin['username']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Since</td>
                                            <td>{{ date('l jS \of F Y', strtotime($admin['created_at']))}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-9">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-edit" data-toggle="tab">Edit Profile</a></li>
                                        {{--<li><a href="#tab-bank" data-toggle="tab">Payment</a></li>--}}
                                    </ul>
                                    <div id="generalTabContent" class="tab-content">
                                        <div id="tab-edit" class="tab-pane fade in active">
                                            {!! Form::open(['url'=>'/adminntw/profile/change/password',
                                            'method'=>'post',
                                            'name'=>'profile-change-password',
                                            'id'=>'profile-change-password-form', 'novalidate'=>'novalidate',
                                            'class'=>'form-horizontal']) !!}
                                            <h3>Account Setting</h3>

                                            <div class="form-group"><label
                                                        class="col-sm-3 control-label">Email</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="text" autocomplete="off"
                                                                                     value="{{$admin['email']}}"
                                                                                     placeholder="username" readonly
                                                                                     disabled
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-3 control-label">Username</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="text"
                                                                                     value="{{$admin['username']}}"
                                                                                     placeholder="username" readonly
                                                                                     disabled
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-3 control-label">Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password"
                                                                                     autocomplete="off"
                                                                                     name="profile[password]"
                                                                                     id="profile-password"
                                                                                     placeholder="password"
                                                                                     class="form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Confirm
                                                    Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password"
                                                                                     autocomplete="off"
                                                                                     name="profile[confirm_password]"
                                                                                     id="profile-confirm-password"
                                                                                     placeholder="Confirm new password"
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                            <button type="submit" name="commit"
                                                    class="btn btn-green btn_change_password">Change password
                                            </button>
                                            {!! Form::close() !!}
                                            <hr/>
                                            {!! Form::open(['url'=>'/adminntw/profile/change', 'method'=>'post',
                                            'name'=>'profile-change',
                                            'id'=>'profile-change-form', 'novalidate'=>'novalidate',
                                            'class'=>'form-horizontal']) !!}
                                            <h3>Profile Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">First
                                                    Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="text"
                                                                                     value="{{$admin['first_name']}}"
                                                                                     name="profile[first_name]"
                                                                                     id="profile-first-name"
                                                                                     placeholder="First name"
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Last
                                                    Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="text"
                                                                                     value="{{$admin['last_name']}}"
                                                                                     name="profile[last_name]"
                                                                                     id="profile-last-name"
                                                                                     placeholder="Last name"
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                            <button type="submit" name="commit" class="btn btn-green btn_save">Save
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                        {{--<div id="tab-bank" class="tab-pane fade in">--}}
                                            {{--<div id="tab-edit" class="tab-pane fade in active">--}}
                                                {{--{!! Form::open(['url'=>'/adminntw/payment/change', 'method'=>'post',--}}
                                                {{--'name'=>'payment-change',--}}
                                                {{--'id'=>'payment-change-form', 'novalidate'=>'novalidate',--}}
                                                {{--'class'=>'form-horizontal']) !!}--}}
                                                {{--<h3>Payment Detils</h3>--}}

                                                {{--<div class="form-group"><label class="col-sm-3 control-label">First--}}
                                                        {{--Name</label>--}}

                                                    {{--<div class="col-sm-9 controls">--}}
                                                        {{--<div class="row">--}}
                                                            {{--<div class="col-xs-4"><input type="text"--}}
                                                                                         {{--value="{{$admin['first_name']}}"--}}
                                                                                         {{--name="profile[first_name]"--}}
                                                                                         {{--id="profile-first-name"--}}
                                                                                         {{--placeholder="First name"--}}
                                                                                         {{--class="form-control"/></div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group"><label class="col-sm-3 control-label">Last--}}
                                                        {{--Name</label>--}}

                                                    {{--<div class="col-sm-9 controls">--}}
                                                        {{--<div class="row">--}}
                                                            {{--<div class="col-xs-4"><input type="text"--}}
                                                                                         {{--value="{{$admin['last_name']}}"--}}
                                                                                         {{--name="profile[last_name]"--}}
                                                                                         {{--id="profile-last-name"--}}
                                                                                         {{--placeholder="Last name"--}}
                                                                                         {{--class="form-control"/></div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<hr/>--}}
                                                {{--<button type="submit" name="commit" class="btn btn-green btn_save">Save--}}
                                                {{--</button>--}}
                                                {{--{!! Form::close() !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
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
    <script src="/assets/dashboard/js/profile.js"></script>
@stop