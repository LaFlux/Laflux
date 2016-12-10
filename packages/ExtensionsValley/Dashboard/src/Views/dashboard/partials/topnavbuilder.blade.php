<?php
                  $topnavigation = new Illuminate\Support\Collection;
                  \Event::fire('admin.topnavigation.groups', [$topnavigation]);
                  $topnavigation_items = [];
                  foreach($topnavigation as $items){
                   $topnavigation_items = array_merge($topnavigation_items,$items['items']);
                  }
                  usort($topnavigation_items, function($a, $b) {
                        return $a['order'] - $b['order'];
                    });

?>

          @if(sizeof($topnavigation_items))
            @foreach($topnavigation_items as $key)
              @includeIf($key['layout'],['title' => $key['title']])
            @endforeach
          @endif
