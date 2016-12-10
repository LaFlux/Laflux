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
        if (isset($user)) {
            $action = 'extensionsvalley.admin.updateuser';
        } else {
            $action = 'extensionsvalley.admin.saveuser';
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
                        {!! Form::text('name', isset($user->name) ? $user->name : \Input::old('name'), [
                            'class'       => 'form-control',
                            'placeholder' => 'User Full Name',
                            'required'    => 'required',
                             $readonly
                        ]) !!}
                        <span class="error_red">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} control-required">
                        {!! Form::label('email', 'Email') !!} <span class="error_red">*</span>
                        {!! Form::email('email',isset($user->email) ? $user->email : \Input::old('email'), [
                            'class'       => 'form-control',
                            'placeholder' => 'Email',
                            'required'    => 'required',
                            $readonly
                        ]) !!}
                        <span class="error_red">{{ $errors->first('email') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} control-required">
                        {!! Form::label('password', 'Password') !!}
                        @if(!isset($user->id))<span class="error_red">*</span> @endif
                        <Input type="password" name="password" id="password" {{$readonly}} class="form-control"
                               @if(!isset($user->id)) required @endif />
                        <span class="error_red">{{ $errors->first('password') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }} control-required">
                        {!! Form::label('password_confirmation', 'Confirm Password') !!}
                        @if(!isset($user->id))<span class="error_red">*</span> @endif
                        <Input type="password" name="password_confirmation" {{$readonly}} id="password_confirmation"
                               class="form-control"
                               @if(!isset($user->id)) required @endif/>
                        <span class="error_red">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('groups') ? 'has-error' : '' }} control-required">
                        {!! Form::label('groups', 'User Groups') !!} <span class="error_red">*</span>
                        {!! Form::select('groups', $groups, isset($user->groups) ? $user->groups :null, [
                            'class'       => 'form-control select2',
                            'required'    => 'required',

                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }} control-required">
                        {!! Form::label('status', 'Status') !!} <span class="error_red">*</span>
                        {!! Form::select('status', array('1'=>'Publish','0'=>'Unpublish'), isset($user->status) ? $user->status :null, [
                            'class'       => 'form-control select2',
                            'required'    => 'required',

                        ]) !!}
                    </div>
                </div>

            </div>

            @if(isset($user->id))
                <Input type="hidden" name="user_id" value="{{$user->id}}"/>
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

