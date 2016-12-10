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

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Upload your zip file</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right">
                            </li>
                        </ul>

                            <a href="{{route('extensionsvalley.admin.manageextension')}}" class="btn btn-primary pull-right">Manage Extensions</a>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <center>
                         {!!Form::open(array('route' => 'extensionsvalley.admin.uploadextension', 'method' => 'post','files'=>true))!!}
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group {{ $errors->has('zipfile') ? 'has-error' : '' }}">
                            Upload the zip file (.zip only allowed)
                            {!! Form::file('zipfile',[
                               'required' => 'required'

                            ])!!}
                            <span class="error_red">  {{ $errors->first('zipfile') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group pull-left">
                              {!! Form::submit('Upload', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>

                          {!! Form::token() !!}
                        {!! Form::close() !!}
                        </center>
                    </div>
                </div>
            <div class="active_bg" style="border-radius: 5px;padding: 5px;">

                 @if(!is_writable( base_path()."/packages"))
                 <div style="color:red">packages folder is not writable</div>
                 @endif

            Make sure the packages folder is writable (chmod -R 777 packages/),also the config/app.php and composer json should be writable by default apache user (chown www-data composer.json config/app.php).
            <br/>
            <h5>After package upload you're getting errors like Service provider not found follow the steps (due to permission issue on development machines)</h5>
            <ul>
                <li>run the commands in the root directory of your project</li>
                <li>php artisan vendor:publish</li>
                <li>composer dumpautoload -o</li>
                <li>php artisan migrate</li>
            </ul>
            <h5>Theme activation tips</h5>
            <ul>
                <li>After theme activation you may see some broken design it may happen due to folder permission issues</li>
                <li>Make sure the public folder is writable for apache user (chown -R www-data public/)</li>
                <li>Make sure the resouces folder is writable for apache user (chown -R www-data resources/)</li>
                <li>Still trouble after activate just try the above commands in the console.</li>
            </ul>
            </div>
            </div>
        </div>






    </div>
@stop
