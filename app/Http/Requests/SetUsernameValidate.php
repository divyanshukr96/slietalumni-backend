<?php

namespace App\Http\Requests;


class SetUsernameValidate extends APIRequest
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
            'token' => 'required|string|exists:username_tokens',
            'email' => 'required|email',
            'username' => "required|regex:/^['\_\-a-zA-Z0-9 ]+$/|min:6|max:50",
            'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => "The username format is invalid only hyphen & underscore is allowed."
        ];
    }

}
