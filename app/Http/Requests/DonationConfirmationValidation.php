<?php

namespace App\Http\Requests;

use App\Rules\UserPasswordVerify;
use Illuminate\Foundation\Http\FormRequest;

class DonationConfirmationValidation extends APIRequest
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
            'password' => ['required', 'min:6', new UserPasswordVerify],
            'confirm_amount' => ['required', 'integer'],
            'description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'confirm_amount' => 'amount'
        ];
    }
}
