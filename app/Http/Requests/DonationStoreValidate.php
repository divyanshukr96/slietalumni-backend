<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;

class DonationStoreValidate extends APIRequest
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
            'member' => 'nullable|exists:users,username',
            'name' => 'required_without:member|string',
            'email' => 'required_without:member|email',
            'mobile' => ['required_without:member', new PhoneNumber()],
            'organisation' => 'required_without:member|string',
            'designation' => 'required_without:member|string',
            'category' => 'required|string',
            'amount' => 'required',
            'receipt' => 'required|file',
        ];
    }

    public function messages()
    {
        return [
            'name.required_without' => "The :attribute field is required",
            'email.required_without' => "The :attribute field is required",
            'mobile.required_without' => "The :attribute field is required",
            'organisation.required_without' => "The :attribute field is required",
            'designation.required_without' => "The :attribute field is required",
            'receipt.file' => 'The :attribute must be image/pdf file',
        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'donation receipt',
            'category' => 'donation category',
        ];
    }
}
