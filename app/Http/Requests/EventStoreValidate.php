<?php

namespace App\Http\Requests;

class EventStoreValidate extends APIRequest
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
            'event' => 'required|exists:event_types,name,deleted_at,NULL',
            'title' => 'required|string|min:8|max:100',
            'description' => 'required|string|min:100',
            'content' => 'nullable|string',
            'venue' => 'required|string|max:100',
            'date' => 'required|date|after_or_equal:today',  // validating the date is after today
            'time' => 'required|date|',
            'image' => 'nullable|image|max:2000'
        ];
    }

    public function messages()
    {
        return [
//            'time.date_format' => 'The time does not match the format H:i.'
        ];
    }
}
