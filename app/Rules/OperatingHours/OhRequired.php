<?php

namespace App\Rules\OperatingHours;

use Illuminate\Contracts\Validation\Rule;

class OhRequired implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !empty($value['opening_time']) && !empty($value['closing_time']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Both opening and closing time required';
    }
}
