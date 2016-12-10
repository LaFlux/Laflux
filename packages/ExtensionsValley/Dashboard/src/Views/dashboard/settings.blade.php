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
                        <h2>Site Settings</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        {!!Form::open(array('route' => 'extensionsvalley.admin.updatesettings', 'method' => 'post','files'=>true))!!}


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('site_name') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('site_name', 'Site Name') !!} <span class="error_red">*</span>
                                    {!! Form::text("settings[site_name]", \WebConf::get('site_name'), [
                                         'class'       => 'form-control',
                                         'placeholder' => 'Your Site Name',
                                         'required'    => 'required',
                                         'tabindex'    => 1
                                     ]) !!}
                                    <span class="error_red"> {{ $errors->first('site_name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('copy_right') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('copy_right', 'Copy Right ') !!} <span class="error_red">*</span>
                                    {!! Form::text("settings[copy_right]", \WebConf::get('copy_right'), [
                                         'class'       => 'form-control',
                                         'placeholder' => 'Copy right info',
                                         'required'    => 'required',
                                         'tabindex'    => 2
                                     ]) !!}
                                    <span class="error_red">{{ $errors->first('copy_right') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group {{ $errors->has('site_logo') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('site_logo', 'Logo') !!} (jpeg,jpg,png,gif 1MB)
                                    {!! Form::file('site_logo',[
                                      'photo' => 'mimes:jpeg,jpg,png,gif|required|max:10000',

                                   ])!!}
                                    <span class="error_red">{{ $errors->first('site_logo') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group ">
                                    @if(\WebConf::get('site_logo') != "")
                                        <img src="{{URL::to('/')}}/{{ \WebConf::get('site_logo') }}" width="80"
                                             alt="logo"/>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group {{ $errors->has('fav_icon') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('fav_icon', 'Fav Icon ') !!} (ico 1MB)
                                    {!! Form::file('fav_icon',[
                                       'photo' => 'mimes:ico,jpg,png,gif|required|max:10000',

                                    ])!!}
                                    <span class="error_red"> {{ $errors->first('fav_icon') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group ">
                                    @if(\WebConf::get('fav_icon') != "")
                                        <img src="{{URL::to('/')}}/{{ \WebConf::get('fav_icon') }}" width="64"
                                             alt="logo"/>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('meta_title', 'SEO Title') !!} <span class="error_red">*</span>
                                    {!! Form::text("settings[meta_title]", \WebConf::get('meta_title'), [
                                         'class'       => 'form-control',
                                         'placeholder' => 'SEO Title',
                                         'required'    => 'required',
                                         'tabindex'    => 5
                                     ]) !!}
                                    <span class="error_red"> {{ $errors->first('meta_title') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('meta_desc') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('meta_desc', 'SEO Description ') !!} <span class="error_red">*</span>
                                    {!! Form::text("settings[meta_desc]", \WebConf::get('meta_desc'), [
                                         'class'       => 'form-control',
                                         'placeholder' => 'SEO Description',
                                         'required'    => 'required',
                                         'tabindex'    => 6
                                     ]) !!}
                                    <span class="error_red">{{ $errors->first('meta_desc') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('meta_keywords') ? 'has-error' : '' }} control-required">
                                    {!! Form::label('meta_keywords', 'SEO Keywords') !!} <span class="error_red">*</span>
                                    {!! Form::text("settings[meta_keywords]", \WebConf::get('meta_keywords'), [
                                         'class'       => 'form-control',
                                         'placeholder' => 'SEO Keywords eg: Books,shops,blogs etc',
                                         'required'    => 'required',
                                         'tabindex'    => 7
                                     ]) !!}
                                    <span class="error_red"> {{ $errors->first('meta_keywords') }}</span>
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
    </div>
@stop
