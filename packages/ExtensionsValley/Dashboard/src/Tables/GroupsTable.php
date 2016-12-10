<?php
namespace ExtensionsValley\Dashboard\Tables;

use ExtensionsValley\Dashboard\Tables\BaseTable;

class GroupsTable extends BaseTable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    public $page_title = "Manage User Groups";

    public $table_name = "groups";

    public $acl_key = "extensionsvalley.dashboard.groups";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\GroupsTable';

    public $overrideview = "";

    public $model_name = 'ExtensionsValley\Dashboard\Models\Group';

    public $listable = ['name' => 'Group Name', 'status' => 'Status', 'created_at' => 'Date'];
    public $show_toolbar = ['view' => 'Show'
        , 'add' => 'Add'
        , 'edit' => 'Edit'
        , 'publish' => 'Publish'
        , 'unpublish' => 'Unpublish'
        , 'trash' => 'Trash'
        , 'restore' => 'Restore'
        , 'forcedelete' => 'Force Delete'
    ];

    public $routes = ['add_route' => 'addgroup'
        , 'edit_route' => 'editgroup'
        , 'view_route' => 'viewgroup'
    ];

    public $advanced_filter = ['layout' => ""
            ,'filters' => [
            'filter_trashed' => 'filter_trashed'
        ]
    ];


    public function getQuery()
    {

        $filter_trashed = \Input::get('filter_trashed');

        $groups = \DB::table('groups')
                ->select('id', 'name', 'status', 'created_at');
        if($filter_trashed == 1){
            $groups = $groups->where('deleted_at','<>', NULL);
        }else{
            $groups = $groups->where('deleted_at', NULL);
        }


        return \Datatables::of($groups)
            ->editColumn('sl', '<input type="checkbox" name="cid[]" value="{{$id}}" class="cid_checkbox"/>')
            ->editColumn('status', '@if($status==1) <span class="glyphicon glyphicon-ok"> Published</span> @else <span class="glyphicon glyphicon-remove"> Unpublished</span> @endif')
            ->editColumn('created_at', '{{date("M-j-Y",strtotime($created_at))}}')
            ->make(true);
    }

}
