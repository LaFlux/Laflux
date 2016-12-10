@extends('Dashboard::dashboard.dashboard')
@section('content-header')

    <!-- Navigation Starts-->
    @include('Dashboard::dashboard.partials.headersidebar')
    <!-- Navigation Ends-->

@stop
@section('content-area')
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <h2>{{$title}}</h2>
                </div>
            </div>
        </div>
        <?php
        if (isset($group)) {
            $action = 'extensionsvalley.admin.updategroup';
        } else {
            $action = 'extensionsvalley.admin.savegroup';
        }
        if (isset($viewmode)) {
            $readonly = "readonly";
        } else {
            $readonly = "";
        }

        ?>
        <div class="x_panel">
            {!!Form::open(array('route' => $action, 'method' => 'post'))!!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} control-required">
                        {!! Form::label('name', 'Name') !!} <span class="error_red">*</span>
                        {!! Form::text('name', isset($group->name) ? $group->name : \Input::old('name'), [
                            'class'       => 'form-control',
                            'placeholder' => 'Name',
                            'required'    => 'required',
                            $readonly
                        ]) !!}
                        <span class="error_red">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }} control-required">
                        {!! Form::label('status', 'Status') !!} <span class="error_red">*</span>
                        {!! Form::select('status', array('1'=>'Publish','0'=>'Unpublish'), isset($group->status) ? $group->status :null, [
                            'class'       => 'form-control select2',
                            'required'    => 'required'
                        ]) !!}
                    </div>
                </div>
            </div>

            @if(isset($group->id))
                <Input type="hidden" name="group_id" value="{{$group->id}}"/>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <a onclick="history.go(-1);" class="btn btn-success">Cancel</a>
                    @if(!isset($viewmode))
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    @endif
                </div>
            </div>
              <input type="hidden" name="accesstoken" value="{{\Input::has('accesstoken') ? \Input::get('accesstoken') : ''}}" />

            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

