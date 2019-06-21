<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;

class AlumniDataCollectionUpdateValidate extends APIRequest
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
        $email = $this->request->get('email') ? $this->request->get('email') : 'NULL';
        return [
            'name' => "required|regex:/^[.\'\-a-zA-Z ]+$/|max:150|unique:alumni_data_collections,name,{$this->alumni_datum},id,email,{$email}",
            "email" => "nullable|email|unique:alumni_data_collections,email,{$this->alumni_datum}",
            'mobile' => ['nullable', new PhoneNumber],
            'programme' => 'nullable',
            'branch' => 'nullable',
            'batch' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y') - 3),
            'passing' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y')),
            'organisation' => 'nullable|string',
            'image' => 'nullable|image|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => "The name contains ony alphabet.",
            'email.unique' => "The email has already been in your data.",
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
