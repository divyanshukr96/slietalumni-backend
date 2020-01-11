<?php

namespace App\Http\Requests;


use App\Traits\MemberTypes;
use Illuminate\Validation\Rule;

class MemberUpdateValidation extends APIRequest
{
    use MemberTypes;
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
        $memberType = self::$executiveMemberType;
        if (in_array($this->sac, [true, '1', 1])) {
            $memberType = self::$sacMemberType;
        }
        return [
            'name' => 'string|min:5',
            'designation' => ['required', 'string', Rule::in($memberType)],
            'from' => 'nullable|required_with:to|date|',
            'to' => 'nullable|date|after:from',
            'image' => 'image|dimensions:ratio=1/1,lte:500',
            'sac' => 'nullable|boolean',
            'profile' => 'nullable|string|exists:users,username'
        ];
    }
}
