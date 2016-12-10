@extends('Dashboard::dashboard.dashboard')
@section('content-header')

    <!-- Navigation Starts-->
    @include('Dashboard::dashboard.partials.headersidebar')
    <!-- Navigation Ends-->

@stop
@section('content-area')

 <!-- page content -->
        <div class="right_col"  role="main">
        <div class="row">

          <?php
                  $widgets = new Illuminate\Support\Collection;
                  \Event::fire('admin.widgets.groups', [$widgets]);
                  $widget_items = [];
                  foreach($widgets as $items){
                   $widget_items = array_merge($widget_items,$items['items']);
                  }
                  usort($widget_items, function($a, $b) {
                        return $a['order'] - $b['order'];
                    });

          ?>

          @if(sizeof($widget_items))
            @foreach($widget_items as $key)
              @includeIf($key['layout'],['layout_col' => $key['col']])
            @endforeach
          @endif

        </div>
    </div>

    <!-- /page content -->
@stop
