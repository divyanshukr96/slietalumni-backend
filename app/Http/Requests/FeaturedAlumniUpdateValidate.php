<?php

namespace App\Http\Requests;


use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;

class FeaturedAlumniUpdateValidate extends APIRequest
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
            'name' => 'nullable|string',
            'email' => ['nullable', 'email', 'max:50', Rule::unique('featured_alumnis')->where(function ($query) {
                return $query->where('id', '<>', $this->featured_alumnus->id)->where('deleted_at', null);
            })],
            'mobile' => ['nullable', new PhoneNumber()],
            'organisation' => 'nullable|string',
            'designation' => 'nullable|string',
            'featured' => 'nullable|date',
            'image' => 'nullable|image|max:2000'
        ];
    }


    public function messages()
    {
        return [
            'alumni.unique' => 'The :attribute has already been featured.',
            'email.unique' => 'The alumni has already been featured.',
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'alumni photo',
            'featured' => 'featured date'
        ];
    }
}
