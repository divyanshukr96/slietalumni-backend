<?php

namespace App\Http\Requests;


class PermissionUpdateValidate extends APIRequest
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
            'display_name' => "nullable|regex:/^[\_\-a-zA-Z ]+$/|max:50",
            'description' => 'nullable|string|max:150'
        ];
    }
}
