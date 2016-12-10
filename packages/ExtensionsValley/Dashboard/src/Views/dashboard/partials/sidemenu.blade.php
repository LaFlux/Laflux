<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    <div class="menu_section">

        @if(!\Schema::hasTable('acl_permission'))
            <?php
            $menugroups = new Illuminate\Support\Collection;
            \Event::fire('admin.menu.groups', [$menugroups]);

            ?>
            <ul class="nav side-menu">
                @foreach($menugroups as $key)
                    <li><a>{!! $key['menu_icon'] !!} {{$key['menu_text']}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @foreach($key['sub_menu'] as $subkey)
                                <li><a href="{{$subkey['link']}}">{{$subkey['menu_text']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @else
            <?php
            $main_menu = \DB::table('acl_permission')
                    ->Where('group_id', \Auth::guard('admin')->user()->groups)
                    ->Where('view',1)
                    ->orderBy('ordering', 'ASC')
                    ->get();


            ?>
            <ul class="nav side-menu">
                @foreach($main_menu as $key)
                    @if($key->parent_menu == 0)
                        <li>
                            <a>{!! $key->icon !!} {{$key->menu_text}}<span class="fa fa-chevron-down"></span></a>
                            @endif
                            <?php
                            $sub_menu = $main_menu->Where('parent_menu', $key->id)->all();
                            ?>
                            <ul class="nav child_menu">
                                @foreach($sub_menu as $subkey)
                                    <li><a href="{{$subkey->link}}">{{$subkey->menu_text}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
            </ul>
        @endif
    </div>

</div>
