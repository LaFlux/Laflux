<div class="col-md-8 col-md-offset-3">
    @if(Session::has('message'))
        <div class="message alert alert-success  col-md-12 text-center">{!! Session::get('message') !!}</div>
    @endif
    @if(Session::has('error'))
        <div class="message alert alert-danger  col-md-12 text-center">{!! Session::get('error') !!}</div>
    @endif
    @if(Session::has('warning'))
        <div class="message alert alert-warning  col-md-12 text-center">{!! Session::get('warning') !!}</div>
    @endif
</div>

