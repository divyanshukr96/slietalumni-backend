<?php

namespace App\Http\Requests;


class RoleStoreValidate extends APIRequest
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
            'name' => 'required|alpha_dash|unique:roles,name|max:35',
            'permission' => 'nullable|array|exists:permissions,name',
            'display_name' => "nullable|regex:/^[\_\-a-zA-Z ]+$/|max:50",
            'description' => 'nullable|string|max:150'
        ];
    }

    public function messages()
    {
        return [
            'permission.exists' => 'The selected permission is not registered.'
        ];
    }

}
