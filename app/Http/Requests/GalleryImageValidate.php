<?php

namespace App\Http\Requests;


class GalleryImageValidate extends APIRequest
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
            'album' => 'nullable|exists:gallery_albums,id',
            'image' => 'required|image|max:2400'
        ];
    }
}
