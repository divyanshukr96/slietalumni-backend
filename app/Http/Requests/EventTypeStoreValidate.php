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
        $rules = [
            'title' => 'required|string|max:60',
            'description' => 'nullable|string|min:100'
        ];
        if (strtoupper(request()->method()) === "POST") {
            $rules['name'] = 'required|alpha_dash|unique:event_types|max:50';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'event type',
        ];
    }
}
