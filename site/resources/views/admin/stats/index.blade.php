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
                        <div class="panel panel-body">
                            <div class="panel-heading">
                                Import Data From CSV Into Database
                            </div>
                            <div class="panel-body pan">
                                {!! Form::open(['url'=>'/adminntw/stats/import',
                                'method'=>'post',
                                'name'=>'stats-import',
                                'enctype'=>'multipart/form-data',
                                'id'=>'stats-import-form', 'novalidate'=>'novalidate',
                                'class'=>'']) !!}
                                <div class="form-body pal">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-red">
                                                Filter
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <div class='input-group date' id='filter_month'>
                                                        <input type='text' class="form-control" name="filter[month]"
                                                               placeholder="Expected month"/>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" multiple="multiple" id="channel_id"
                                                        name="filter[channel_id][]">
                                                    @foreach($channels as $channel)
                                                        <option value="{{$channel['daily_channel_id']}}">{{$channel['daily_channel_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-block btn_choose_csv">
                                                    Browse a CSV file
                                                </button>
                                                <input id="csv_file" name="csv_file" type="file" class="hide" accept=".csv"/>
                                                <span class="csv_file_name">
                                                    No file
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary btn_import_data">
                                                    Import
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content_script')
    <script src="/assets/admin/js/import.js"></script>
@stop