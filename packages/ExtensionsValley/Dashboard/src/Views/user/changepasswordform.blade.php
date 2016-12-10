@extends('Dashboard::dashboard.dashboard')
@section('content-main')
    <div id="wrapper">
        <!-- Navigation Starts-->
    @include('Dashboard::dashboard.partials.navigationbar')
    <!-- Navigation Ends-->
    </div>
@stop
@section('content-area')
    <div id="page-wrapper">
        <!-- Dashboard title Starts -->
    @include('Dashboard::dashboard.partials.dashboardtitlesection')
    <!-- Dashboard title Ends -->
        <?php
        $action = 'extensionsvalley.admin.updateuserpassword';
        ?>
        {!!Form::open(array('route' => $action, 'method' => 'post'))!!}
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group control-required">
                    {!! Form::label('oldpassword', 'Current Password') !!}
                    <input type="password" name="oldpassword" class="form-control" required/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group control-required">
                    {!! Form::label('newpassword', 'New Password') !!}
                    <input type="password" name="newpassword" class="form-control" required/>

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group control-required">
                    {!! Form::label('confirmpassword', 'Confirm Password') !!}
                    <input type="password" name="confirmpassword" class="form-control" required/>
                </div>
            </div>

        </div>


        @if(isset($user->id))
            <Input type="hidden" name="user_id" value="{{$user->id}}"/>
        @endif
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::token() !!}
        {!! Form::close() !!}
    </div>
@stop

