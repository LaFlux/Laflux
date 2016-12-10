<?php
namespace ExtensionsValley\Dashboard\Validators;

class GroupValidation
{

    public function getRules()
    {
        return [
            'name' => 'required|max:200|unique:groups',
            'status' => 'required',
        ];
    }

    public function getUpdateRules($group)
    {
        return [
            'name' => 'required|max:200|unique:groups,name,' . $group->id,
            'status' => 'required',
        ];
    }

}
