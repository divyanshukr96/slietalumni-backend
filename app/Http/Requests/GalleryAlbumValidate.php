<?php

namespace App\Http\Requests;


class GalleryAlbumValidate extends APIRequest
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
            'title' => 'required|string|min:2',
            'description' => 'required|string|min:5',
            'cover' => 'nullable|image|max:2400'
        ];
    }
}
