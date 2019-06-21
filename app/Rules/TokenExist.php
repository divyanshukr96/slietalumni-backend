<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class TokenExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        $token = $parameters[0];
        $context = DB::table('username_tokens')->where('token', request()->get($token))->first();
        return $context ? true : false;
    }

}
