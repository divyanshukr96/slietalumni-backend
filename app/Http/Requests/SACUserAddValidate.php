<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;

class SACUserAddValidate extends APIRequest
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
            'name' => "required|regex:/^[.\'\-a-zA-Z ]+$/|max:50",
            'email' => 'required|email|max:50|unique:users,email',
            'mobile' => ['required', new PhoneNumber],
            'username' => "required|regex:/^[\_\-a-zA-Z0-9 ]+$/|min:6|max:50|unique:users",
            'password' => 'required|string|min:8',
            'profile' => 'nullable|image|max:2000',
            'active' => 'required|accepted',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => "The email has already been registered.",
            'username.regex' => "The username format is invalid only hyphen & underscore is allowed.",
            'profile.max' => 'The :attribute may not be greater than 2 MB.',
        ];
    }

}
