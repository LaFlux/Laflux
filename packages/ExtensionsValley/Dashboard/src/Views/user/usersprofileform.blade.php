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
        $action = 'extensionsvalley.admin.updateusersprofile';
        ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Password Change</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        {!!Form::open(array('route' => 'extensionsvalley.admin.updateuserpassword', 'method' => 'post','files'=>true))!!}


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('password', 'Current Password') !!} <span class="error_red">*</span>
                                    <input type="password" name="current_password" class="form-control" required=""/>
                                    {{ $errors->first('current_password') }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('new_password', 'New Password') !!} <span class="error_red">*</span>
                                    <input type="password" name="password" class="form-control" required=""/>
                                    {{ $errors->first('password') }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('confirm_password', 'Confirm Password') !!} <span class="error_red">*</span>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           required=""/>
                                    {{ $errors->first('confirm_password') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                <a href="javascript:;" onclick="history.go(-1);" class="btn btn-success">Clear</a>
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::token() !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="x_panel">
            <div class="x_title">
                <h2>Basic Profile</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!!Form::open(array('route' => $action, 'method' => 'post','files'=>true))!!}

                <div class="row">

                    <?php
                    $path = "packages/extensionsvalley/dashboard/images/profile/" . \Auth::User()->id;
                    $media = isset($usersprofile->media) ? $usersprofile->media : "";
                    ?>
                    <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style="height: 150px;">
                        <div class='form-group control-required'>
                            @if($media == "")
                                <center><img src='{{URL::to('/')}}/packages/extensionsvalley/dashboard/images/profile/user.png'
                                             width='150px' height='150px'/></center>
                            @else
                                <center><img src='{{URL::to('/')}}/{{ $media }}' width='150px'/></center>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('address_1') ? 'has-error' : '' }} control-required">
                            {!! Form::label('address', 'Address') !!} <span class="error_red">*</span>
                            {!! Form::text('address', isset($usersprofile->address) ? $usersprofile->address : \Input::old('address'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Address',
                                'required'    => 'required',
                                'tabindex'    => 4
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('address') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('street') ? 'has-error' : '' }} control-required">
                            {!! Form::label('street', 'Street') !!} <span class="error_red">*</span>
                            {!! Form::text('street', isset($usersprofile->street) ? $usersprofile->street : \Input::old('street'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Street',
                                'required'    => 'required',
                                'tabindex'    => 5
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('street') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('address_2') ? 'has-error' : '' }} control-required">
                            {!! Form::label('city', 'City') !!} <span class="error_red">*</span>
                            {!! Form::text('city', isset($usersprofile->city) ? $usersprofile->city : \Input::old('city'), [
                                'class'       => 'form-control',
                                'placeholder' => 'City',
                                'required'    => 'required',
                                'tabindex'    => 6
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('city') }}</span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                            Upload or Change your photo (max:1 MB)
                            {!! Form::file('photo',[
                               'photo' => 'mimes:jpeg,jpg,png,gif|required|max:10000',

                            ])!!}
                            <span class="error_red">  {{ $errors->first('photo') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }} control-required">
                            {!! Form::label('state', 'State') !!} <span class="error_red">*</span>
                            {!! Form::text('state', isset($usersprofile->state) ? $usersprofile->state : \Input::old('state'), [
                                'class'       => 'form-control',
                                'placeholder' => 'State',
                                'required'    => 'required',
                                'tabindex'    => 7
                            ]) !!}
                            <span class="error_red">  {{ $errors->first('state') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }} control-required">
                            {!! Form::label('first_name', 'First Name') !!} <span class="error_red">*</span>
                            {!! Form::text('first_name', isset($usersprofile->first_name) ? $usersprofile->first_name : \Input::old('first_name'), [
                                'class'       => 'form-control',
                                'placeholder' => 'First Name',
                                'required'    => 'required',
                                'tabindex'    => 1
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('first_name') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }} control-required">
                            {!! Form::label('last_name', 'Last Name') !!} <span class="error_red">*</span>
                            {!! Form::text('last_name', isset($usersprofile->last_name) ? $usersprofile->last_name : \Input::old('last_name'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Last Name',
                                'required'    => 'required',
                                'tabindex'    => 2
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('last_name') }}</span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('pin') ? 'has-error' : '' }} control-required">
                            {!! Form::label('zip', 'Zip') !!} <span class="error_red">*</span>
                            {!! Form::text('zip', isset($usersprofile->zip) ? $usersprofile->zip : \Input::old('zip'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Zip code',
                                'required'    => 'required',
                                'tabindex'    => 8
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('zip') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} control-required">
                            {!! Form::label('email', 'Email') !!} <span class="error_red">*</span>
                            {!! Form::email('email', empty(\Input::old('email')) ? \Auth::guard('admin')->user()->email : \Input::old('email'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Email address',
                                'required'    => 'required',
                                'tabindex'    => 3
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('Mobile') ? 'has-error' : '' }} control-required">
                            {!! Form::label('mobile', 'Mobile') !!} <span class="error_red">*</span>
                            {!! Form::text('mobile', isset($usersprofile->mobile) ? $usersprofile->mobile : \Input::old('mobile'), [
                                'class'       => 'form-control',
                                'placeholder' => 'Mobile',
                                'required'    => 'required',
                                'tabindex'    => 9
                            ]) !!}
                            <span class="error_red"> {{ $errors->first('mobile') }}</span>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <a href="javascript:;" onclick="history.go(-1);" class="btn btn-success">Clear</a>
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::token() !!}
                {!! Form::close() !!}
            </div>
        </div>


    </div>
@stop
