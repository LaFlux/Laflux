<?php
namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Validators\UserValidation;
use ExtensionsValley\Dashboard\Models\Department;
use ExtensionsValley\Dashboard\Models\Group;
use ExtensionsValley\Dashboard\Models\Role;
use ExtensionsValley\Dashboard\Models\traits\DashboardTraits;
use ExtensionsValley\Dashboard\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{

    use DashboardTraits;

    public function __construct()
    {

        $this->getNavigationBar();
        $this->getWidgets();
    }

    public function addUser()
    {

        $title = 'Add New User';
        $groups = Group::getGroups();
        return \View::make('Dashboard::user.userform', compact('title', 'groups'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function saveUser()
    {

        $validation = \Validator::make(\Input::all(), with(new UserValidation)->getRules());

        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.adduser',['accesstoken'=>\Input::get('accesstoken')])->withErrors($validation)->withInput();
        }

        $user_name = \Input::get('name');
        $user_email = \Input::get('email');
        $user_password = \Input::get('password');
        $status = \Input::get('status');
        $group = \Input::get('groups');


        $result = User::create([
            'name' => $user_name,
            'email' => $user_email,
            'status' => $status,
            'groups' => $group,
            'password' => bcrypt($user_password),
        ]);


        //Send Registarion Email with queue
        ##$emailq_id = $this->sendEmail(['name' => $user_name, 'email' => $user_email, 'password' => $user_password]);


        return redirect('admin/ExtensionsValley/dashboard/list/users')->with(['message' => 'User Details added successfully!']);
    }

    public function sendEmail($data)
    {

        return $insert_id = \Mail::queue('Dashboard::email.registration', compact('data'), function ($mail) use ($data) {
            $mail->to($data['email'], $data['name'])
                ->subject(env('APP_NAME') . ': Invitation');
        });
    }

    public function editUser($id)
    {

        $title = 'Edit User Details';
        $groups = Group::getGroups();
        $user = User::findOrFail($id);
        return \View::make('Dashboard::user.userform', compact('title', 'user', 'groups'));
    }

    public function viewUser($id)
    {

        $title = 'View User Details';
        $groups = Group::getGroups();
        $user = User::findOrFail($id);
        $viewmode = 'view';
        return \View::make('Dashboard::user.userform', compact('title', 'user', 'groups', 'viewmode'));
    }

    public function updateUser(Request $request)
    {

        $user_id = $request->input('user_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $status = $request->input('status');
        $group = $request->input('groups');
        $password = $request->input('password');

        $user = User::findOrFail($user_id);
        $validation = \Validator::make($request->only('user_id', 'name', 'email', 'status', 'groups')
            , with(new UserValidation)->getUpdateRules($user));
        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.edituser', ['id' => $user->id,'accesstoken'=>\Input::get('accesstoken')])->withErrors($validation)->withInput();
        }

        User::Where('id', $user->id)->update(['name' => $name
            , 'email' => $email
            , 'status' => $status
            , 'groups' => $group]);

        if (\Input::has('password')) {
            User::Where('id', $user->id)->update(['password' => bcrypt($password)]);
        }

        return redirect('admin/ExtensionsValley/dashboard/list/users')->with(['message' => 'User Details updated successfully!']);
    }

    public function changeUserpassword()
    {
        $title = 'Change Password';
        $user = User::where('id', '=', \Auth::guard('admin')->User()->id)->first();
        return \View::make('Dashboard::user.changepasswordform', compact('title', 'user'));
    }

    public function updateUserpassword(Request $request)
    {
        $user_id = \Auth::guard('admin')->user()->id;
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $confirmpassword = $request->input('confirmpassword');
        $user = User::findOrFail($user_id);
        if ($newpassword == $confirmpassword) {
            if (Hash::check($oldpassword, $user->password)) {
                User::Where('id', $user_id)
                    ->update(['password' => bcrypt($newpassword),
                    ]);
                return redirect()->route('extensionsvalley.admin.changeuserpassword', ['id' => $user_id])->with(['message' => 'Passsword Changed successfully!']);
            } else {
                return redirect()->route('extensionsvalley.admin.changeuserpassword', ['id' => $user_id])->with(['error' => 'Old password is incorret!']);
            }
        } else {
            return redirect()->route('extensionsvalley.admin.changeuserpassword', ['id' => $user_id])->with(['error' => 'New Password and Confirm password not match!']);
        }

    }


}
