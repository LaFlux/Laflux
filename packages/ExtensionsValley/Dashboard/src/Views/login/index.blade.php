<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}} </title>
    @if(\WebConf::get('fav_icon') != "")
        <link rel="shortcut icon" href="{{URL::to('/')}}/{{ \WebConf::get('fav_icon') }}"/>
    @endif

    <!-- Bootstrap -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/font-awesome.min.css")}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/custom.min.css")}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/core-admin.css")}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/green.css")}}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/jquery.min.js")}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/bootstrap.min.js")}}"></script>

    <!-- iCheck -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/icheck.min.js")}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/custom.min.js")}}"></script>

</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        @if(Session::has('message'))
                            <div class="message alert alert-success  col-md-12 text-center">{{ Session::get('message') }}</div>
                        @endif
                        @if(Session::has('error'))
                            <div class="message alert alert-danger  col-md-12 text-center">{{ Session::get('error') }}</div>
                        @endif
                        @if(Session::has('warning'))
                            <div class="message alert alert-warning  col-md-12 text-center">{{ Session::get('warning') }}</div>
                        @endif
                    </div>
                </div>
                {!!Form::open(array('route' => 'extensionsvalley.admin.auth', 'method' => 'post'))!!}
                <form>
                    <h1>
                        @if(\WebConf::get('site_logo') != "")
                            <img src="{{URL::to('/')}}/{{ \WebConf::get('site_logo') }}" width="64"/>
                        @else
                            <i class="fa fa-paw"></i>
                        @endif
                    </h1>
                    <div>
                        @if ($errors->has('email'))
                            <span class="error_red"><b>{{ $errors->first('email') }}</b></span>
                        @endif
                        <input type="text" name="email" class="form-control" required="" placeholder="Email"/>

                    </div>
                    <div>
                        @if ($errors->has('password'))
                            <span class="error_red"><b>{{ $errors->first('password') }}</b></span>
                        @endif
                        <input type="password" name="password" class="form-control" required="" placeholder="Password"/>
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Log in</button>
                        <input name="remember" type="checkbox" class="flat" value="Remember Me">
                        Remember Me&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="" href="{{route('extensionsvalley.admin.reset')}}">Lost
                            your password?</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <div class="clearfix"></div>
                        <br/>

                        <div>
                            <h1>
                                @if(\WebConf::get('fav_icon') == "")
                                    <i class="fa fa-paw"></i>
                                @endif
                                {{\WebConf::get('site_name')}}</h1>
                            <p> {{\WebConf::get('copy_right')}} <br/> Powered by <b><a
                                            href="http://extensionsvalley.com">Extensions Valley</a></b></p>
                        </div>
                    </div>
                </form>
                {!! Form::token() !!}
                {!! Form::close() !!}
            </section>
        </div>


    </div>
</div>
</body>
</html>
