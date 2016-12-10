<?php
namespace ExtensionsValley\Dashboard\Validators;

class UsersprofileValidation
{

    public function EmailValidate($id)
    {

        return [
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'mobile' => 'required'
        ];
    }

    public function PasswordValidate()
    {

        return [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function getUpdateRules($usersprofile)
    {

        return [
            'address' => 'required|max:255',
            'street' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'photo' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'state' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'zip' => 'required',
            'mobile' => 'required'
        ];
    }

}
