<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('extensionsvalley.admin.dashboard')}}" class="site_title">
                @if(\WebConf::get('site_name') != "")
                    <i class="fa fa-paw"></i>
                    <span>{{\WebConf::get('site_name')}}</span>
                @else
                    <i class="fa fa-paw"></i> <span>ExtensionsValley</span>
                @endif
            </a>
        </div>

        <div class="clearfix"></div>
        @include('Dashboard::dashboard.partials.avatarsection')

        <br/>
        <!-- sidebar menu -->
    @include('Dashboard::dashboard.partials.sidemenu')
    <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
    @include('Dashboard::dashboard.partials.sidemenufooter')
    <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
@include('Dashboard::dashboard.partials.topnavigation')
<!-- /top navigation -->
<!-- Message Starts-->
@include('Dashboard::dashboard.partials.statusmessage')
<!-- Message Ends-->
