@extends('Dashboard::email.basetemplate')
@section('name') {{$data['name']}} @stop

@section('message-body')
    You have to verify your email address for activate your account : <a href="{{ $data['link'] }}"> Activate Now </a>

@stop
