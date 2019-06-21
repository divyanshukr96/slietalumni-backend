<?php

namespace App\Http\Requests;

use App\Rules\PermissionName;

class PermissionStoreValidate extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'alpha_dash', 'unique:permissions,name', 'max:35', new PermissionName],
//            'name' => 'required|alpha_dash|unique:permissions,name|max:35|',
            'display_name' => "nullable|regex:/^[\_\-a-zA-Z ]+$/|max:50",
            'description' => 'nullable|string|max:150'
        ];
    }
}
