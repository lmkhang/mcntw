@inject('admincontroller', 'App\Http\Controllers\Admin\AdminController')
@extends('admin.templates.master')

@section('title')
    {{$page_title}}
@stop

@section('content')
    <div class="page-content">
        <div id="tab-general">
            {{--Members List--}}
            @include('admin.members.list')
        </div>
    </div>
@stop

@section('content_script')
    <script>
        var tax_pay_bank = '{{$tax_pay_bank}}';
        var currency = '{{$currency}}';
    </script>
    <script src="/assets/admin/js/members.js"></script>
@stop