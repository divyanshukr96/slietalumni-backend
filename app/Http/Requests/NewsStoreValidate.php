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
        return [
            'heading' => 'required|string|max:200',
            'content' => 'required|string|min:300',
            'image' => 'required|image|max:1024'
        ];
    }
}
