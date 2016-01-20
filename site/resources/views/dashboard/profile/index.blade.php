@inject('controller', 'App\Http\Controllers\Controller')
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
                                        {{--<div class="text-center mbl"><a href="#" class="btn btn-green"><i--}}
                                        {{--class="fa fa-upload"></i>&nbsp;--}}
                                        {{--Upload</a></div>--}}
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
                                            <td>Payment Email</td>
                                            <td>{{$user['payment_email']}}</td>
                                        </tr>
                                        @if($user['from_refer'])
                                            <tr>
                                                <td>From Refer ID</td>
                                                <td>
                                                    {{$user['from_refer']}}<br/>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Refer ID</td>
                                            <td>
                                                {{$user['refer']}}<br/>
                                                <button type="button" class="copy_refer btn btn-green"
                                                        onclick="window.prompt('Copy link below', '{{url('/?refer='.$user['refer'])}}'); return false;">
                                                    Copy Refer Link
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Member Since</td>
                                            <td>{{ date('l jS \of F Y', strtotime($user['created_at']))}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-9">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-edit" data-toggle="tab">Edit Profile</a></li>
                                        <li><a href="#tab-bank" data-toggle="tab">Payment</a></li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content">
                                        <div id="tab-edit" class="tab-pane fade in active">
                                            @if($user['registration_system']==1)
                                                {!! Form::open(['url'=>'/dashboard/profile/change/password',
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
                                                                                         value="{{$user['email']}}"
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
                                                        <div class="col-xs-4"><input type="text"
                                                                                     value="{{$user['first_name']}}"
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
                                                                                     value="{{$user['last_name']}}"
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
                                            <hr/>
                                            <button type="submit" name="commit" class="btn btn-green btn_save">Save
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                        <div id="tab-bank" class="tab-pane fade in">
                                            <div id="tab-edit" class="tab-pane fade in active">
                                                {!! Form::open(['url'=>'/dashboard/payment/change', 'method'=>'post',
                                                'name'=>'payment-change',
                                                'id'=>'payment-change-form', 'novalidate'=>'novalidate',
                                                'class'=>'form-horizontal']) !!}
                                                <h2>Payment Detail (<span class="text-danger">{{$payment_notice}}</span>)
                                                </h2>
                                                @if($controller->hasFlash('errors'))
                                                    @foreach($controller->getFlash('errors') as $att)
                                                        @foreach($att as $err)
                                                            <div class="text-warning common_message">
                                                                {{$err}}
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                                <div class="form-group">
                                                    <select class="form-control selectpicker payment_method"
                                                            name="payment[method]">
                                                        @foreach($payment_method as $k=>$pm)
                                                            <option value="{{$k}}" {{isset($payment['payment_method']) && $payment['payment_method']==$k?'selected':''}}>{{$pm}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{--Bank Info--}}
                                                <div class="row bank_method">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Bank</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <select class="form-control select_bank"
                                                                            name="payment[bank]">
                                                                        @foreach($banks as $b)
                                                                            <option value="{{$b['bank_id']}}"  {{isset($payment['bank_id']) && $payment['bank_id']==$b['bank_id']?'selected':''}}>{{$b['bank_name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">ID Number (Bank)</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['id_number_bank'])?$payment['id_number_bank']:''}}"
                                                                           name="payment[number_bank]"
                                                                           id="payment-number-bank"
                                                                           placeholder="ID Number"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">First
                                                            Name</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['first_name'])?$payment['first_name']:''}}"
                                                                           name="payment[first_name]"
                                                                           id="payment-first-name"
                                                                           placeholder="First name"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">Middle
                                                            Name</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['mid_name'])?$payment['mid_name']:''}}"
                                                                           name="payment[mid_name]"
                                                                           id="payment-mid_name"
                                                                           placeholder="Middle name"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Last Name</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['last_name'])?$payment['last_name']:''}}"
                                                                           name="payment[last_name]"
                                                                           id="payment-last-name"
                                                                           placeholder="Last name"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Address</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['address'])?$payment['address']:''}}"
                                                                           name="payment[address]"
                                                                           id="payment-address"
                                                                           placeholder="Address"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Ward</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['ward'])?$payment['ward']:''}}"
                                                                           name="payment[ward]"
                                                                           id="payment-ward"
                                                                           placeholder="Ward"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">District</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['district'])?$payment['district']:''}}"
                                                                           name="payment[district]"
                                                                           id="payment-district"
                                                                           placeholder="District"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">City</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="text"
                                                                           value="{{isset($payment['city'])?$payment['city']:''}}"
                                                                           name="payment[city]"
                                                                           id="payment-city"
                                                                           placeholder="City"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Phone</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="tel"
                                                                           value="{{isset($payment['phone'])?$payment['phone']:''}}"
                                                                           name="payment[phone]"
                                                                           id="payment-phone"
                                                                           placeholder="Phone"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Email</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="email"
                                                                           value="{{isset($payment['contact_email'])?$payment['contact_email']:''}}"
                                                                           name="payment[contact_email]"
                                                                           id="payment-contact-email"
                                                                           placeholder="Email"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--End Bank Info--}}

                                                {{--Paypal Info--}}
                                                <div class="row paypal_method">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Email</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4">
                                                                    <input type="email"
                                                                           value="{{isset($payment['paypal_email'])?$payment['paypal_email']:''}}"
                                                                           name="payment[paypal_email]"
                                                                           id="payment-paypal-email"
                                                                           placeholder="Email"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--End Paypal Info--}}
                                                <hr/>
                                                <button type="button" name="commit"
                                                        class="btn btn-green btn_send_payment">Send payment information
                                                </button>
                                                {!! Form::close() !!}
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
    <script>
        var arrCheck = new Array();
    </script>
    <script src="/assets/dashboard/js/profile.js"></script>
@stop