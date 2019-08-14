<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;

class AlumniRegistrationStoreValidation extends APIRequest
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
            'email' => 'required|email|max:50|unique:alumni_registrations,email',
            'mobile' => ['required', new PhoneNumber],
            'programme' => 'required',
            'branch' => 'required',
            'batch' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y') - 3),
            'passing' => 'required|digits:4|integer|min:1980|max:' . (date('Y')),
            'organisation' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'linkdein' => 'nullable|url',
            'image' => "required|image|max:2000",
            'accept' => 'required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => "The name contains only alphabet.",
            'email.unique' => 'The :attribute has already been registered.',
            'linkdein.url' =>'The linkdein profile link is invalid.',
            'image.max' => 'The :attribute may not be greater than 2 MB.'
        ];
    }

    public function attributes()
    {
        return [
            'passing' => 'passing year',
            'image' => 'photo',
        ];
    }
}
