<?php
namespace ExtensionsValley\Dashboard\Tables;

use ExtensionsValley\Dashboard\Tables\BaseTable;

class UsersTable extends BaseTable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    public $page_title = "Manage Users";

    public $table_name = "users";

    public $acl_key = "extensionsvalley.dashboard.users";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\UsersTable';

    public $overrideview = "";

    public $model_name = 'ExtensionsValley\Dashboard\Models\User';

    public $listable = ['name' => 'Name'
        , 'email' => 'Email'
        , 'groupsname' => 'Groups'
        , 'status' => 'Status'
        , 'created_at' => 'Date'
    ];

    public $show_toolbar = ['view' => 'Show'
        , 'add' => 'Add'
        , 'edit' => 'Edit'
        , 'publish' => 'Publish'
        , 'unpublish' => 'Unpublish'
        , 'trash' => 'Trash'
        , 'restore' => 'Restore'
        , 'forcedelete' => 'Force Delete'
    ];

    public $routes = ['add_route' => 'adduser'
        , 'edit_route' => 'edituser'
        , 'view_route' => 'viewuser'
    ];

    public $advanced_filter = ['layout' => "Dashboard::user.advancedfilters.usersfilter"
        , 'filters' => [
            'filter_group' => 'filter_group'
            , 'filter_status' => 'filter_status'
            , 'filter_trashed' => 'filter_trashed'
        ]
    ];


    public function getQuery()
    {

        $search = \Input::get('customsearch');
        $filter_group = \Input::get('filter_group');
        $filter_trashed = \Input::get('filter_trashed');
        $filter_status = \Input::has('filter_status') ? \Input::get('filter_status') : '-1';

        $users = \DB::table('users')
            ->leftjoin('groups', 'users.groups', '=', 'groups.id')
            ->select(['users.name', 'users.email', 'users.status', 'users.created_at', 'groups.name as groupsname', 'users.id'])
            ->Where('users.id', '<>', 1);

        if($filter_trashed == 1){
            $users = $users->where('users.deleted_at','<>', NULL);
        }else{
            $users = $users->where('users.deleted_at', NULL);
        }

        if ($filter_status != -1) {
            $users = $users->Where('users.status', $filter_status);
        }
        if ($filter_group > 0) {
            $users = $users->Where('users.groups', $filter_group);
        }

        return \Datatables::of($users)
            ->editColumn('sl', '<input type="checkbox"  name="cid[]" value="{{$id}}" class="cid_checkbox flat"/>')
            ->editColumn('status', '@if($status==1) <span class="glyphicon glyphicon-ok"></span> @else <span class="glyphicon glyphicon-remove"></span> @endif')
            ->editColumn('created_at', '{{date("M-j-Y",strtotime($created_at))}}')
            ->filter(function ($query) use ($search, $filter_group, $filter_status,$filter_trashed) {
                $query->where('users.name', 'like', $search . '%')
                    ->orwhere('users.email', 'like', $search . '%')
                    ->Where('users.id', '<>', 1);

                if($filter_trashed == 1){
                    $query->where('users.deleted_at','<>', NULL);
                }else{
                    $query->where('users.deleted_at', NULL);
                }
                if ($filter_status != -1) {
                    $query->Where('users.status', $filter_status);
                }
                if ($filter_group > 0) {
                    $query->Where('users.groups', $filter_group);
                }

            })
            ->make(true);
    }

}
