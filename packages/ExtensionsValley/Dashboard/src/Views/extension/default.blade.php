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
                        <h2>Installed Packages</h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right">
                            </li>
                        </ul>

                            <a href="{{route('extensionsvalley.admin.addnewpackage')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Install or Update Package</a>
                            <a class="btn btn-round btn-dark pull-right"
                            href="{{route('extensionsvalley.admin.manageextension',['status' => 1])}}" >Active  : {{$full_extensions->where('status',1)->count()}}</a>
                            <a class="btn btn-round btn-dark pull-right"
                            href="{{route('extensionsvalley.admin.manageextension',['status' => 0])}}" >Disabled :  {{$full_extensions->where('status',0)->count()}}</a>
                            <a class="btn btn-round btn-dark pull-right"
                            href="{{route('extensionsvalley.admin.manageextension')}}" >Total :
                            {{$full_extensions->count()}}</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <?php $count = 1;?>
                    <div class="row">
                    @foreach($extensions as $items)
                      @if($count % 2 != 0)
                        <div class="row">
                      @endif
                        <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 profile_details">
                        <div class="well profile_view @if($items->status == 1) active_bg @else disable_bg @endif">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>{{ucfirst($items->vendor)}}</i></h4>
                            <div class="left col-xs-8">
                              <h2>{{ucfirst($items->name)}}</h2>
                              <p><strong>Version: </strong> {{$items->version}}. </p>
                              <ul class="list-unstyled">
                                <li>Author: {{ucfirst($items->author)}}</li>
                                <li>Type: {{$items->package_type}} </li>
                                <li>Installed: {{date('Y-m-d',strtotime($items->created_at))}}
                                @if(!empty($items->updated_at))
                                  / {{date('Y-m-d',strtotime($items->updated_at))}}</li>
                                @endif
                              </ul>
                            </div>

                            <div class="right col-xs-4 text-center">
                              @if(file_exists(base_path()."/public/".$items->icon))
                                <img src="{{URL::to('/')}}/{{$items->icon}}" alt="" class="img-circle img-responsive">
                              @else
                                <img src="{{URL::to('/')}}/packages/extensionsvalley/dashboard/images/laflux-logo.png" alt="" class="img-circle img-responsive">
                              @endif
                            </div>
                          </div>
                          <div class="col-xs-12 bottom">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            @if(!empty($items->website))
                              <a href="{{$items->website}}" target="_blank" class="btn btn-dark btn-xs">
                                 Repository
                              </a>
                            @endif
                            @if($items->is_paid == 0)
                              <a class="btn btn-warning btn-xs">Free</a>
                            @else
                              <a class="btn btn-info btn-xs">Paid</a>
                            @endif
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                 @if($items->vendor == "ExtensionsValley"
                                 && ($items->name == "Dashboard"))
                                    <a href="{{$items->website}}" target="_blank" class="btn btn-dark btn-xs pull-right">Website</a>
                                 @else

                                   @if($items->status == 0 && $items->name != "Basetheme" )
                                      <?php
                                      $url = ('uninstallpackage/'.$items->id);
                                      ?>
                                    <a class="btn btn-danger btn-xs pull-right"
                                    onclick="uninstallPackage('{{$url}}')">Uninstall</a>
                                   @endif
                                   @if($items->status == 1 && $items->name != "Basetheme" )
                                    <a class="btn btn-success btn-xs pull-right @if($items->package_type == 'Core Theme') hide @endif"
                                    href="{{route('extensionsvalley.admin.disablepackage',['id'=> $items->id])}}">Deactivate</a>
                                   @elseif($items->status == 0)
                                    <a class="btn btn-primary btn-xs pull-right"
                                    href="{{route('extensionsvalley.admin.activatepackage',['id'=> $items->id])}}">Activate</a>
                                   @else
                                      <a href="{{$items->website}}" target="_blank" class="btn btn-dark btn-xs pull-right">Website</a>
                                    @endif
                                @endif
                            </div>
                          </div>
                        </div>
                      </div>
                       @if($count % 2 == 0)
                        </div>
                      @endif
                      <?php $count++; ?>
                    @endforeach
                    </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
