<?php
namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Validators\UsersprofileValidation;
use ExtensionsValley\Dashboard\Models\traits\DashboardTraits;
use ExtensionsValley\Dashboard\Models\Usersprofile;
use ExtensionsValley\Dashboard\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Routing\Controller;

class UsersprofileController extends Controller
{
    use DashboardTraits;

    public function __construct()
    {
        $this->getNavigationBar();
        $this->getWidgets();
    }

    /**
     * Create a new usersprofile instance after a valid registration.
     *
     * @param  array $data
     * @return usersprofile
     */
    public function editUsersprofile()
    {

        $title = 'My Account Settings';

        $usersprofile = Usersprofile::where('user_id', '=', \Auth::guard('admin')->User()->id)->first();

        return \View::make('Dashboard::user.usersprofileform', compact('title', 'usersprofile'));
    }

    public function updateUsersprofile(Request $request)
    {

        $usersprofile = Usersprofile::Where('user_id', \Auth::guard('admin')->user()->id)
            ->first();

        $validation = \Validator::make($request->all()
            , with(new UsersprofileValidation)->EmailValidate(\Auth::guard('admin')->user()->id));
        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.editusersprofile')->withErrors($validation)->withInput();
        }
        $validation = \Validator::make($request->all()
            , with(new UsersprofileValidation)->getUpdateRules($usersprofile));
        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.editusersprofile')->withErrors($validation)->withInput();
        }

        $media = "";
        if ($request->file('photo')) {
            $destinationPath = "packages/extensionsvalley/dashboard/images/profile/" . \Auth::guard('admin')->user()->id;

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $final_location = $destinationPath . "/";
            $file_name = time();
            $request->file('photo')->move($final_location, $file_name . '.' . $request->file('photo')->getClientOriginalExtension());
            $media = $final_location . $file_name . '.' . $request->file('photo')->getClientOriginalExtension();
        } else {
            $media = Usersprofile::where('user_id', \Auth::guard('admin')->user()->id)
                ->value('media');
        }

        $address = $request->input('address');
        $street = $request->input('street');
        $city = $request->input('city');
        $state = $request->input('state');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $zip = $request->input('zip');

        $count = \DB::table('user_profile')
            ->Where('user_id', \Auth::guard('admin')->user()->id)
            ->count();


        User::Where('id', \Auth::guard('admin')->user()->id)
            ->update(['email' => $email]);
        if ($count == 0) {
            $result = Usersprofile::create([
                'user_id' => \Auth::guard('admin')->user()->id,
                'address' => $address,
                'street' => $street,
                'media' => $media,
                'state' => $state,
                'city' => $city,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'mobile' => $mobile,
                'zip' => $zip
            ]);
            return redirect()->route('extensionsvalley.admin.editusersprofile')->with(['message' => 'Usersprofile Details updated successfully!']);
        } else {


            $result = Usersprofile::Where('user_id', \Auth::guard('admin')->user()->id)
                ->update([
                    'address' => $address,
                    'street' => $street,
                    'media' => $media,
                    'state' => $state,
                    'city' => $city,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'mobile' => $mobile,
                    'zip' => $zip
                ]);
        }
        return redirect()->route('extensionsvalley.admin.editusersprofile')->with(['message' => 'Usersprofile Details updated successfully!']);

    }

    public function updateUserpassword(Request $request)
    {

        $user_id = \Auth::guard('admin')->user()->id;
        $current_password = $request->input('current_password');
        $password = $request->input('password');
        $confirm_password = $request->input('password_confirmation');

        $validation = \Validator::make($request->all()
            , with(new UsersprofileValidation)->PasswordValidate());
        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.editusersprofile')->withErrors($validation)->withInput();
        }

        $user = User::findOrFail($user_id);

        if (Hash::check($current_password, $user->password)) {
            User::Where('id', $user_id)
                ->update(['password' => bcrypt($password),
                ]);
            return redirect()->route('extensionsvalley.admin.editusersprofile')->with(['message' => 'Passsword Changed successfully!']);
        } else {
            return redirect()->route('extensionsvalley.admin.editusersprofile')->with(['error' => 'Old password is incorret!']);
        }
    }


}
