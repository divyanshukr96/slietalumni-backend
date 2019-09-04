<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class NotExists implements Rule
{
    private $table;
    private $column;

    /**
     * Create a new rule instance.
     *
     * @param $table
     * @param $column
     */
    public function __construct($table, $column = 'NULL')
    {
        $this->table = $table;
        $this->column = $column;
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
        $data = DB::table($this->table);
        if ($this->column != "NULL") $data->where($this->column, $value);
        else $data->where($attribute, $value);
        return $data->first() ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been SAA member.';
    }
}
