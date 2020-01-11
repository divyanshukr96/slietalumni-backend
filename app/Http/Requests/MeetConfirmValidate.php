<?php

namespace App\Http\Requests;


use App\Rules\UserPasswordVerify;

class MeetConfirmValidate extends APIRequest
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
            "mode" => "required|in:CASH,ONLINE",
            'password' => ['required_if:mode,ONLINE', 'min:6', new UserPasswordVerify],
            'receipt' => 'required_if:mode,ONLINE|file|mimes:pdf,jpeg,bmp,png,jpg',
            'amount' => 'required|' // amount validator add
        ];
    }

    public function messages()
    {
        return [
            'receipt.mimes' => "The :attributes must be a file of type: pdf or image."
        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'payment receipt'
        ];
    }
}
