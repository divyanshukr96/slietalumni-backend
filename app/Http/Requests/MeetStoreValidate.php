<?php

namespace App\Http\Requests;

use App\Rules\NotExists;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class MeetStoreValidate extends FormRequest
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
        if (strtoupper(request()->method()) !== "POST")
            return [
                'family' => 'nullable|boolean',
                'accommodation' => 'nullable|boolean',
            ];

        return [
            'member' => 'nullable|exists:users,email|unique:alumni_meets,email',

            'name' => "required_without:member|regex:/^[.\'\-a-zA-Z ]+$/|max:50",
            'email' => 'required_without:member|email|max:50|unique:alumni_meets,email',
//            'email' => ['required', 'email', 'max:50', new NotExists('users'), 'unique:registrations,email'],
            'mobile' => ['required_without:member', new PhoneNumber],
            'programme' => 'required_without:member',
            'branch' => 'required_without:member',
            'batch' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y') - 3),
            'passing' => 'required_without:member|digits:4|integer|min:1980|max:' . (date('Y')),
            'organisation' => 'required_without:member|string|max:100',
            'designation' => 'required_without:member|string|max:100',

            'family' => 'nullable|boolean',
            'accommodation' => 'nullable|boolean',
            'requirements' => 'nullable|string|max:600',
        ];
    }

    public function messages()
    {
        return [
            'member.unique' => "You are already registered for Alumni Meet",
            'name.regex' => "The name contains only alphabet.",
            'email.unique' => 'The :attribute has already been registered this Meet.',
            'name.required_without' => "The :attribute field is required",
            'email.required_without' => "The :attribute field is required",
            'mobile.required_without' => "The :attribute field is required",
            'programme.required_without' => "The :attribute field is required",
            'branch.required_without' => "The :attribute field is required",
            'passing.required_without' => "The :attribute field is required",
            'organisation.required_without' => "The :attribute field is required",
            'designation.required_without' => "The :attribute field is required",
        ];
    }

    public function attributes()
    {
        return [
            'passing' => 'passing year',
        ];
    }
}
