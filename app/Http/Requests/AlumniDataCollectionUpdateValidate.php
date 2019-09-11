<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

/**
 * @property mixed alumni_datum
 * @property mixed email
 */
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
//        $email = $this->email ? $this->email === $this->alumni_datum->email ? 'NULL' : $this->email : 'NULL';
//        dd($email);
        return [
//            'name' => "required|regex:/^[.\'\-a-zA-Z ]+$/|max:150|unique:data_collections,name,{$this->alumni_datum->name},id,email,{$email}",
//            "email" => "nullable|email|unique:data_collections,email,{$email}",
//            "email" => ["nullable", "email", "unique:data_collections,email,{$email}"],

//            'name' => ["required", "regex:/^[.\'\-a-zA-Z ]+$/", "max:150", "unique:data_collections,name,{$this->alumni_datum->name},id,email,{$email}"],
            'name' => ["required", "regex:/^[.\'\-a-zA-Z ]+$/", "max:150", Rule::unique('data_collections', 'name')
                ->where(function ($query) use ($email) {
                    return $query->where('id', '!=', $this->alumni_datum->id)
                        ->where('email', $email)
                        ->where('deleted_at', null);
                })],
            "email" => ["nullable", "email", Rule::unique('data_collections', 'email')
                ->where(function ($query) {
                    return $query->where('id', '!=', $this->alumni_datum->id)->where('deleted_at', null);
                })],
            'mobile' => ['nullable', new PhoneNumber],
            'programme' => 'nullable',
            'branch' => 'nullable',
            'batch' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y') - 3),
            'passing' => 'nullable|digits:4|integer|min:1980|max:' . (date('Y')), //add validation for check the passing year after batch
            'organisation' => 'nullable|string',
            'designation' => 'nullable|string', //designation field
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
