<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }


    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->buildResponse($validator));
    }

    /**
     * @param $validator
     * @return JsonResponse
     */
    protected function buildResponse($validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = [];
        foreach ($errors as $key => $data) {
            $response[$key] = $errors[$key][0];
        }
        return response()->json([
            'status' => "invalid data",
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $response
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

}
