<?php

namespace App\Http\Requests;


use DB;

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
        $context = DB::table('username_tokens')->where('token', request()->get('token'))->first();
        if ($context) return [
            'token' => 'bail|required|string|exists:username_tokens',
            'email' => 'bail|required|email|exists:alumni_registrations|unique:users',
            'username' => "bail|required|regex:/^[\_\-a-zA-Z0-9]+$/|min:6|max:50|unique:users",
            'password' => 'required|string|min:8'
        ];
        return ['token' => 'bail|required|string|exists:username_tokens'];
    }

    public function messages()
    {
        return [
            'token.exists' => 'The selected link is invalid.',
            'email.exists' => "The email has not been registered.",
            'email.unique' => "The email has already been registered.",
            'username.regex' => "The username format is invalid only hyphen & underscore is allowed.",
        ];
    }

}
