<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}} | {{\WebConf::get('site_name')}}</title>
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
    <!-- Datatables -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/datatables/dataTables.bootstrap.min.css")}}"
          rel="stylesheet">
    <link href="{{asset("packages/extensionsvalley/dashboard/css/datatables/buttons.bootstrap.min.css")}}"
          rel="stylesheet">
    <!-- Select2 -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/select2.min.css")}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{asset("packages/extensionsvalley/dashboard/css/bootstrap-progressbar-3.3.4.min.css")}}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/jquery.min.js")}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset("packages/extensionsvalley/dashboard/js/bootstrap.min.js")}}"></script>

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
    @yield('content-header')
    @yield('content-area')
    <!-- Footer Starts-->
    @include('Dashboard::dashboard.partials.footer')
    <!-- Footer Ends-->
    </div>
</div>

<!-- iCheck -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/icheck.min.js")}}"></script>
<!-- Datatables -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/dataTables.bootstrap.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/buttons.bootstrap.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/buttons.flash.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/buttons.html5.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/buttons.print.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/dataTables.responsive.min.js")}}"></script>
<script src="{{asset("packages/extensionsvalley/dashboard/js/datatables/responsive.bootstrap.js")}}"></script>
<!-- select 2 JavaScript -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/select2.full.min.js")}}"></script>
<!-- Custom Core JavaScript -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/core-admin.js")}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/custom.min.js")}}"></script>
<!-- Tiny Mce Editor JavaScript -->
<script src="{{asset("packages/extensionsvalley/dashboard/js/tinymce/tinymce.min.js")}}"></script>
<script>tinymce.init({
            selector: 'textarea.texteditor', theme: "modern",
            subfolder: "",
            height : "400",
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor filemanager"
            ],
            image_advtab: true,
            content_css: '{{asset("packages/extensionsvalley/dashboard/js/tinymce/skins/lightgray/content.min.css")}}',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
        });</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(".select2").select2();
    })
</script>
</body>
</html>
