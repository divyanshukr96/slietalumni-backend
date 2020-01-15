<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicNoticeValidate extends APIRequest
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
            'notice' => 'required|min:200',
            'notice_till' => 'required|date|after:today'
        ];
    }

    public function attributes()
    {
        return [
            'notice' => 'notice content'
        ];
    }
}
