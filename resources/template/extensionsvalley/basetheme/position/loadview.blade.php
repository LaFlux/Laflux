<?php  /* $positions = new Illuminate\Support\Collection;
        \Event::fire('website.template.positions', [$positions]);
            if(!empty($positions[$themeHelper->active_template_name])){
            foreach ($positions[$themeHelper->active_template_name] as $items) {
                if($position == $items['position']){
                ?>
                    @includeIf($items['layout'])
                <?php
                }
        }
    }*/

    $mod_items = ExtensionsValley\Modulemanager\Models\Modulemanager::getItemwithPosition($position);
    $current_url = Request::path();
    if(sizeof($mod_items)){
        foreach($mod_items as $mod_item){
            if(trim($mod_item->params)){
                $params = (array)json_decode($mod_item->params);
            }else{
                $params = [];
            }
            if($mod_item->is_all_page == 1){
                ?>
                   @includeIf($mod_item->layout,$params)
                <?php
            }else{
                $slugs = explode(",",$mod_item->pages);
                if(in_array($current_url,$slugs)){
                   ?>
                    @includeIf($mod_item->layout,$params)
                <?php
                }
            }
        }
    }


?>
