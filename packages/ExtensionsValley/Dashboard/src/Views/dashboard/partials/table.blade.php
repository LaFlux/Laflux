@extends('Dashboard::dashboard.dashboard')
@section('content-header')

    <!-- Navigation Starts-->
    @include('Dashboard::dashboard.partials.headersidebar')
    <!-- Navigation Ends-->

@stop
@section('content-area')
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <h2>{{$title}}</h2>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                @if(!empty($table->show_toolbar))
                    @include('Dashboard::dashboard.partials.toolbarsection')
                @endif
            </div>
        </div>
        <div class="row">
            @if(!empty($table->advanced_filter))
                @includeIF($table->advanced_filter['layout'])
            @endif
        </div>


        {!!Form::open(array('route' => 'extensionsvalley.admin.actions', 'method' => 'post','class'=>'admin_form', 'id'=>'admin_listing','name'=>'admin_listing'))!!}
        <div class="x_panel">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered bulk_action" id="datatable-buttons">
                    <thead>
                    <tr>
                        <th width="7%"><input class="flat" type="checkbox" id="checkall" name="checkall"/></th>
                        @foreach($table->listable as $key=>$values)
                            <th>{{$values}}</th>
                        @endforeach
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        @if(sizeof($table->routes))
            @if(isset($table->routes['add_route']))
                <input type="hidden" name="add_route" id="add_route" value="{{$table->routes['add_route']}}/"/>
            @endif
            @if(isset($table->routes['edit_route']))
                <input type="hidden" name="edit_route" id="edit_route" value="{{$table->routes['edit_route']}}/"/>
            @endif
            @if(isset($table->routes['view_route']))
                <input type="hidden" name="view_route" id="view_route" value="{{$table->routes['view_route']}}/"/>
            @endif
        @endif
        <input type="hidden" name="table_name" id="table_name" value="{{$table->table_name}}"/>
        <input type="hidden" name="acl_key" id="acl_key" value="{{base64_encode($table->acl_key)}}"/>
        <input type="hidden" name="return_url" id="return_url" value="{{base64_encode(Request::url())}}"/>
        <input type="hidden" name="model_name" id="model_name" value="{{base64_encode($table->model_name)}}"/>
        <input type="hidden" name="action_type" id="action_type" value=""/>
        <input type="hidden" name="others" id="others" value="@if(\Input::has('others')) 1 @else 0 @endif"/>

        {!! Form::token() !!}
        {!! Form::close() !!}

        <form name="addeditview" id="addeditview"  action=""  method="get" />
        <input type="hidden" name="accesstoken" id="accesstoken" value="{{base64_encode($table->acl_key)}}"/>
        <input type="hidden" id="filter_trashed" value="{{\Input::has('filter_trashed') ? 1 : 0 }}"></input>
        {!! Form::token() !!}
        </form>


    </div>
    <script>
        jQuery(document).ready(function () {
            var _token = jQuery('name[_token]').val();
            var handleDataTableButtons = function () {
                jQuery('#datatable-buttons').DataTable({
                    dom: "Bfrtip",
                    buttons: ['pageLength',
                        {
                            extend: "copy",
                            className: "btn-md"
                        },
                        {
                            extend: "csv",
                            className: "btn-md"
                        },
                        /* {
                         extend: "excel",
                         className: "btn-md"
                         },*/
                        {
                            extend: "pdfHtml5",
                            className: "btn-md"
                        },
                        {
                            extend: "print",
                            className: "btn-md"
                        }
                    ],
                    "responsive": true,
                    "columnDefs": [{"targets": 0, "orderable": false}],
                    "aaSorting": [[1, 'desc']],
                    "serverSide": true,
                    "processing": true,
                    "ajax": {
                        url: "{{route('extensionsvalley.admin.ajax.list',['namespace' => $table->namespace,'tables' => $table->table_name ])}}",
                        data: function (d) {
                            d.customsearch = jQuery("input[type=search]").val(),
                                    @if(!empty($table->advanced_filter['filters']))
                                            @foreach($table->advanced_filter['filters'] as $filterkey=>$filterval)
                                            d.{{$filterkey}} = jQuery.trim(jQuery("#{{$filterkey}}").val()),
                                    @endforeach
                                            @endif
                                            d.others = jQuery.trim(jQuery("#others").val());
                        }
                    },

                    "columns": [
                        {data: 'sl', name: 'id'},
                            @foreach($table->listable as $key=>$values)
                        {
                            data: '{{$key}}', name: '{{$key}}'
                        },
                        @endforeach
                    ]


                });
            };
            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();
            TableManageButtons.init();

            jQuery('#datatable-buttons').on('draw.dt', function () {
                jQuery('input').iCheck({
                    checkboxClass: 'icheckbox_flat-green'
                });
            });
        });
    </script>
@stop
