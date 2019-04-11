<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;

class AlumniDataCollectionStoreValidate extends APIRequest
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
            'name' => "required|regex:/^[.\'\-a-zA-Z ]+$/|max:150",
            'email' => 'nullable|email',
            'mobile' => ['nullable', new PhoneNumber],
            'programme' => 'nullable',
            'branch' => 'nullable',
            'batch' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y') - 3),
            'passing' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y')),
            'organisation' => 'nullable|string',
            'accept' => 'required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => "The name contains ony alphabet."
        ];
    }

    public function attributes()
    {
        return [
            'batch' => 'batch year',
            'passing' => 'passing year',
        ];
    }
}
