@extends('dashboard.templates.master')

@section('title')
    {{$page_title}}
@stop
@section('full_name')
    {{$name}}
@stop

@section('add_more_navbar')
    : {{$name}}
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
                                                    src="{{$user['gavatar']}}" alt=""
                                                    class="img-responsive"/></div>
                                        <div class="text-center mbl"><a href="#" class="btn btn-green"><i
                                                        class="fa fa-upload"></i>&nbsp;
                                                Upload</a></div>
                                    </div>
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                        @if($user['registration_system']==1)
                                        <tr>
                                            <td>User Name</td>
                                            <td>{{$user['username']}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Email</td>
                                            <td>{{$user['email']}}</td>
                                        </tr>
                                        {{--<tr>--}}
                                        {{--<td>Status</td>--}}
                                        {{--<td><span class="label label-success">Active</span></td>--}}
                                        {{--</tr>--}}
                                        {{--<tr>--}}
                                        {{--<td>User Rating</td>--}}
                                        {{--<td><i class="fa fa-star text-yellow fa-fw"></i><i--}}
                                        {{--class="fa fa-star text-yellow fa-fw"></i><i--}}
                                        {{--class="fa fa-star text-yellow fa-fw"></i><i--}}
                                        {{--class="fa fa-star text-yellow fa-fw"></i><i--}}
                                        {{--class="fa fa-star text-yellow fa-fw"></i></td>--}}
                                        {{--</tr>--}}
                                        <tr>
                                            <td>Member Since</td>
                                            <td>{{ date('l jS \of F Y', strtotime($user['created_at']))}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    {{--<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog"--}}
                                         {{--aria-hidden="true">--}}
                                        {{--<div class="modal-content">--}}
                                            {{--<ul class="list-inline item-details">--}}
                                                {{--<li><a href="http://themifycloud.com">Admin templates</a></li>--}}
                                                {{--<li><a href="http://themescloud.org">Bootstrap themes</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-md-9">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-edit" data-toggle="tab">Edit Profile</a></li>
                                        {{--<li><a href="#tab-messages" data-toggle="tab">Messages</a></li>--}}
                                    </ul>
                                    <div id="generalTabContent" class="tab-content">
                                        <div id="tab-edit" class="tab-pane fade in active">
                                            @if($user['registration_system']==1)
                                            {!! Form::open(['url'=>'/dashboard/profile/change/password', 'method'=>'post',
                                            'name'=>'profile-change-password',
                                            'id'=>'profile-change-password-form', 'novalidate'=>'novalidate',
                                            'class'=>'form-horizontal']) !!}
                                                <h3>Account Setting</h3>

                                                <div class="form-group"><label
                                                            class="col-sm-3 control-label">Username</label>

                                                    <div class="col-sm-9 controls">
                                                        <div class="row">
                                                            <div class="col-xs-4"><input type="text"
                                                                                         value="{{$user['username']}}"
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
                                                            <div class="col-xs-4"><input type="password" autocomplete="off"
                                                                                         name="profile[password]"
                                                                                         id="profile-password"
                                                                                         placeholder="password"
                                                                                         class="form-control"/>
                                                                <span>Leave a blank if you do not change</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-3 control-label">Confirm
                                                        Password</label>

                                                    <div class="col-sm-9 controls">
                                                        <div class="row">
                                                            <div class="col-xs-4"><input type="password" autocomplete="off"
                                                                                         name="profile[confirm_password]"
                                                                                         id="profile-confirm-password"
                                                                                         placeholder="Confirm new password"
                                                                                         class="form-control"/></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                                <button type="submit" name="commit" class="btn btn-green btn_change_password">Change password</button>
                                                {!! Form::close() !!}
                                                <hr/>
                                            @endif
                                            {!! Form::open(['url'=>'/dashboard/profile/change', 'method'=>'post',
                                            'name'=>'profile-change',
                                            'id'=>'profile-change-form', 'novalidate'=>'novalidate',
                                            'class'=>'form-horizontal']) !!}
                                            <h3>Profile Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">First
                                                    Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="text" value="{{$user['first_name']}}"
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
                                                        <div class="col-xs-4"><input type="text" value="{{$user['last_name']}}"
                                                                                     name="profile[last_name]"
                                                                                     id="profile-last-name"
                                                                                     placeholder="Last name"
                                                                                     class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-3 control-label">Country</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <select class="form-control" name="profile[country]"
                                                                    id="profile-country">
                                                                <option value=""></option>
                                                                @foreach($countries as $code=>$cn)
                                                                    <option value="{{$code}}" {{strtolower($code)==strtolower($user['country'])?'selected':''}}>{{$cn['nativetongue']?$cn['nativetongue']:$cn['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label
                                                        class="col-sm-3 control-label">About</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><textarea
                                                                    name="profile[about]" id="profile-about"
                                                                    rows="3"
                                                                    class="form-control">{{htmlspecialchars_decode($user['about'])}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<hr/>--}}
                                            {{--<h3>Contact Setting</h3>--}}

                                            {{--<div class="form-group"><label class="col-sm-3 control-label">Mobile--}}
                                            {{--Phone</label>--}}

                                            {{--<div class="col-sm-9 controls">--}}
                                            {{--<div class="row">--}}
                                            {{--<div class="col-xs-9"><input type="text"--}}
                                            {{--placeholder="mobile phone"--}}
                                            {{--class="form-control"/></div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group"><label--}}
                                            {{--class="col-sm-3 control-label">Google</label>--}}

                                            {{--<div class="col-sm-9 controls">--}}
                                            {{--<div class="row">--}}
                                            {{--<div class="col-xs-9"><input type="text"--}}
                                            {{--placeholder="website"--}}
                                            {{--class="form-control"/></div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group"><label--}}
                                            {{--class="col-sm-3 control-label">Facebook</label>--}}

                                            {{--<div class="col-sm-9 controls">--}}
                                            {{--<div class="row">--}}
                                            {{--<div class="col-xs-9"><input type="text"--}}
                                            {{--placeholder="facebook"--}}
                                            {{--class="form-control"/></div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group"><label--}}
                                            {{--class="col-sm-3 control-label">Twitter</label>--}}

                                            {{--<div class="col-sm-9 controls">--}}
                                            {{--<div class="row">--}}
                                            {{--<div class="col-xs-9"><input type="text"--}}
                                            {{--placeholder="twitter"--}}
                                            {{--class="form-control"/></div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            <hr/>
                                            <button type="submit" name="commit" class="btn btn-green btn_save">Save</button>
                                            {!! Form::close() !!}
                                        </div>
                                        <div id="tab-messages" class="tab-pane fade in">
                                            <div class="row mbl">
                                                <div class="col-lg-6"><span style="margin-left: 15px"></span><input
                                                            type="checkbox"/><a href="#"
                                                                                class="btn btn-success btn-sm mlm mrm"><i
                                                                class="fa fa-send-o"></i>&nbsp;
                                                        Write Mail</a><a href="#" class="btn btn-white btn-sm"><i
                                                                class="fa fa-trash-o"></i>&nbsp;
                                                        Delete</a></div>
                                                <div class="col-lg-6">
                                                    <div class="input-group"><input type="text"
                                                                                    class="form-control"/><span
                                                                class="input-group-btn"><button type="button"
                                                                                                class="btn btn-white">
                                                                Search
                                                            </button></span></div>
                                                </div>
                                            </div>
                                            <div class="list-group"><a href="#" class="list-group-item"><input
                                                            type="checkbox"/><span
                                                            class="fa fa-star text-yellow mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star text-yellow mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a><a
                                                        href="#" class="list-group-item"><input type="checkbox"/><span
                                                            class="fa fa-star-o mrm mlm"></span><span
                                                            style="min-width: 120px; display: inline-block;"
                                                            class="name">Bhaumik Patel</span><span>Sed ut perspiciatis unde</span>&nbsp;
                                                    - &nbsp;<span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span><span
                                                            class="badge">12:10 AM</span><span
                                                            class="pull-right mrl"><span
                                                                class="glyphicon glyphicon-paperclip"></span></span></a>
                                            </div>
                                        </div>
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