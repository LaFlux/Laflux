<?php
namespace ExtensionsValley\Dashboard\Validators;

class UserValidation
{

    public function getRules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'status' => 'required',
        ];
    }

    public function getUpdateRules($user)
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'status' => 'required',
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'min:6',
        ];
    }

}
