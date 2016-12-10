 <div id="fh5co-navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
<?php
        $menu_items = ExtensionsValley\Menumanager\Models\Menuitems::getallMenus($position);

?>
                        @if(sizeof($menu_items))
                            @foreach($menu_items as $menuitem)
                                @if($menuitem->parent_menu == 0)
                            <li @if(Request::path() === $menuitem->source) class="active" @endif>
                            <a @if($menuitem->is_new_tab == 1) target='_blank' @endif
                               href="{{url("$menuitem->source")}}">
                               <span>{{$menuitem->menu_name}}<span class="border"></span></span>

                             </a>
                                </li>
                                @endif
                            @endforeach
                        @endif

                    </ul>
</div>
