<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    @includeIf('Basetheme::partials.metadata')
    @includeIf('Basetheme::partials.stylesheet')
    @yield('extra-styles')
    </head>

    <body>
        @includeIf('Basetheme::partials.header')



        @yield('content-main')


        @includeIf('Basetheme::partials.footer')
        @includeIf('Basetheme::partials.footerscript')
        @yield('extra-scripts')
    </body>
</html>
