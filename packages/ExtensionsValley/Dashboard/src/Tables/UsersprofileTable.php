<?php
namespace ExtensionsValley\Dashboard\Tables;

use ExtensionsValley\Dashboard\Tables\BaseTable;

class UsersprofileTable extends BaseTable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    public $page_title = "Users Profiles";

    public $table_name = "usersprofile";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\UsersprofileTable';

    public $listable = ['id' => 'ID', 'user_id' => 'User ID', 'address_1' => 'Address 1', 'address_2' => 'Address 2', 'media' => 'Media', 'street' => 'Street', 'state' => 'State', 'pin' => 'Pin', 'phone' => 'Phone', 'mobile' => 'Mobile', 'created_at' => 'Date'];

    public $overrideview = "";

    public $add_route_name = "addusersprofile/";

    public $edit_route_name = "editusersprofile/";

    public $tool_bar = false;

    public $model_name = 'ExtensionsValley\Dashboard\Models\Usersprofile';

    public function getQuery()
    {

        $search = \Input::get('customsearch');

        $usersprofile = \DB::table('usersprofile')
            ->select(['usersprofile.id', 'usersprofile.user_id', 'usersprofile.address_1', 'usersprofile.address_2', 'usersprofile.media', 'usersprofile.street', 'usersprofile.state', 'usersprofile.pin', 'usersprofile.phone', 'usersprofile.mobile', 'usersprofile.created_at'])
            ->whereNull('usersprofile.deleted_at');

        return \Datatables::of($usersprofile)
            ->editColumn('sl', '<input type="checkbox" name="cid[]" value="{{$id}}" class="cid_checkbox"/>')
            ->editColumn('address_1', '{{$address_1}}')
            ->editColumn('address_2', '{{$address_2}}')
            ->editColumn('created_at', '{{date("M-j-Y",strtotime($created_at))}}')
            ->filter(function ($query) use ($search) {

                $query->where('usersprofile.address_1', 'like', $search . '%')
                    ->orwhere('usersprofile.address_2', 'like', $search . '%')
                    ->whereNull('usersprofile.deleted_at');
            })
            ->make(true);
    }

}
