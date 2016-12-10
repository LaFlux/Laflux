<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <?php
                        $profile_image = 'packages/extensionsvalley/dashboard/images/profile/user.png';
                        $icon = \DB::table('user_profile')->Where('user_id', \Auth::guard('admin')->user()->id)->value('media');
                        if (!empty($icon)) {
                            $profile_image = $icon;
                        }
                        ?>
                        <img src="{{URL::to('/')}}/{{$profile_image}}" alt="">
                        {{ ucfirst(\Auth::guard('admin')->user()->name)}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{route('extensionsvalley.admin.editusersprofile')}}"> Profile</a></li>
                        @if(\Auth::guard('admin')->user()->groups == 1)
                            <li>
                                <a href="{{route('extensionsvalley.admin.gensettings')}}">
                                    <span>General Settings</span>
                                </a>
                            </li>
                            <li><a href="{{route('extensionsvalley.admin.manageextension')}}">Extension Manager</a></li>
                        @endif
                        <li><a href="{{route('extensionsvalley.admin.logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                @include('Dashboard::dashboard.partials.topnavbuilder')
                 <li><a href="{{url('/')}}" target="_blank"><b>Visit Front Page</b></a>
                 </li>
            </ul>
        </nav>
    </div>
</div>
