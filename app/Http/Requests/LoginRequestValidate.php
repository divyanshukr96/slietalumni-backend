<?php

namespace App\Http\Requests;


/**
 * @property mixed remember_me
 */
class LoginRequestValidate extends APIRequest
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
            'email' => 'required_without:username|string|email',
            'username' => 'required_without:email|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'email.required_without' => 'The email field is required',
            'username.required_without' => "The email / username field is required."
        ];
    }
}
