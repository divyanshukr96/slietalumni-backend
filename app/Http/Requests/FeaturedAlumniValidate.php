<?php

namespace App\Http\Requests;

use App\Rules\CustomRule;
use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeaturedAlumniValidate extends APIRequest
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
        if ($this->request->has('alumni')) {
            return [
                'alumni' => ['nullable', 'uuid', 'exists:users,id,deleted_at,NULL',
                    Rule::unique('featured_alumnis', 'alumni_id')->where(function ($query) {
                        return $query->where('featured', '>=', Carbon::today())->where('deleted_at', null);
                    })],
                'featured' => 'required|date|after_or_equal:today',
                'image' => 'required_without:alumni|image|max:2000'
            ];
        }
        return [
            'alumni' => 'nullable',
            'name' => 'required_without:alumni|string',
            'email' => ['required', 'email', 'max:50', Rule::unique('featured_alumnis')->where(function ($query) {
                return $query->where('featured', '>=', Carbon::today())->where('deleted_at', null);
            })],
            'mobile' => ['nullable', new PhoneNumber()],
            'organisation' => 'required_without:alumni|string',
            'designation' => 'required_without:alumni|string',
            'featured' => 'required|date|after_or_equal:today',
            'image' => 'required_without:alumni|image|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'name.required_without' => 'The :attribute field is required.',
            'organisation.required_without' => 'The :attribute field is required.',
            'designation.required_without' => 'The :attribute field is required.',
            'image.required_without' => 'The :attribute field is required.',
            'featured.after_or_equal' => 'The :attribute must be after or equal to today.',
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


//'nullable|uuid|exists:alumnis,user_id,deleted_at,NULL|' .
