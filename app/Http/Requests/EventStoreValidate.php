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
            'event' => 'required|exists:event_types,name',
            'description' => 'required|string|min:200',
            'venue' => 'required|string|max:100',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
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
