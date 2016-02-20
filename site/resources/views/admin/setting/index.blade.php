@extends('admin.templates.master')

@section('title')
    {{$page_title}}
@stop


@section('content')
    <div class="page-content">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-md-4">
                    <div class="btn btn-block btn-blue btn-square">System</div>
                    <div id="generalTabContent" class="tab-content">
                        <div id="tab-edit" class="tab-pane fade in active">
                            {!! Form::open(['url'=>'/adminntw/setting/change',
                            'method'=>'post',
                            'name'=>'setting-change',
                            'id'=>'setting-change-form', 'novalidate'=>'novalidate',
                            'class'=>'form-horizontal']) !!}

                            @foreach($setting as $s)
                                <div class="form-group">
                                    <label
                                            class="col-sm-3 control-label">{{$s['title']}}</label>

                                    <div class="col-sm-8 controls">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <input type="hidden" name="id[]" autocomplete="off"
                                                       value="{{$s['config_id']}}"
                                                       class="form-control"/>
                                                <input type="text" name="setting_{{$s['config_id']}}" autocomplete="off"
                                                       value="{{$s['value']}}"
                                                       class="form-control"/>{{$s['description']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr/>
                            <button type="submit" name="commit"
                                    class="btn btn-green btn_change_password">Save
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="btn btn-block btn-blue btn-square">Stats</div>
                    <div id="generalTabContent" class="tab-content">
                        <div id="tab-edit" class="tab-pane fade in active">
                            {!! Form::open(['url'=>'/adminntw/setting/change_stats',
                            'method'=>'post',
                            'name'=>'setting-change_stats',
                            'id'=>'setting-change_stats-form', 'novalidate'=>'novalidate',
                            'class'=>'form-horizontal']) !!}

                            @foreach($stats_show as $s)
                                <div class="form-group">
                                    <label
                                            class="col-sm-3 control-label">{{$s['title']}}</label>

                                    <div class="col-sm-8 controls">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <input type="hidden" name="id[]" autocomplete="off"
                                                       value="{{$s['home_id']}}"
                                                       class="form-control"/>
                                                <input type="text" name="home_{{$s['home_id']}}" autocomplete="off"
                                                       value="{{$s['value']}}"
                                                       class="form-control"/>{{$s['description']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr/>
                            <button type="submit" name="commit"
                                    class="btn btn-green btn_change_password">Save
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('content_script')
    {{--<script src="/assets/dashboard/js/setting.js"></script>--}}
@stop