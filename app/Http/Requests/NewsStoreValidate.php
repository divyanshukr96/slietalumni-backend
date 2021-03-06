<?php

namespace App\Http\Requests;


class NewsStoreValidate extends APIRequest
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
        if (strtoupper(request()->method()) === "POST")
            return [
                'title' => 'required|string|max:200',
                'description' => 'required|string|min:50',
                'content' => 'required|string|min:300',
                'cover' => [request()->news ? 'nullable' : 'required', 'image', 'max:2000'],
                'social_link' => 'nullable|url'
            ];
        return [
            'title' => 'nullable|string|max:200',
            'description' => 'nullable|string|min:50',
            'content' => 'nullable|string|min:300',
            'cover' => 'nullable|image|max:2000',
            'social_link' => 'nullable|url'
        ];
    }
}
