@extends('Dashboard::email.basetemplate')
@section('name') Admin @stop

@section('message-body')
    New Contact Request <br/><br/>

    Name: {{$data['name']}}<br/>
    Email: {{$data['email']}}<br/>
    Mobile : {{$data['phone']}}<br/>
    Message : {{$data['content']}}



@stop
