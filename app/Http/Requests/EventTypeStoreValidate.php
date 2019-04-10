<?php

namespace App\Http\Requests;


class EventTypeStoreValidate extends APIRequest
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
            'name' => 'required|string|unique:event_types',
            'title' => 'required|string',
            'about' => 'nullable|string|min:150'
        ];
    }
}
