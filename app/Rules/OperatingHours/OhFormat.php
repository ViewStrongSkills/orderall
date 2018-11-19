<?php

namespace App\Rules\OperatingHours;

use Illuminate\Contracts\Validation\Rule;

class OhFormat implements Rule
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
        $pattern = '/^(([0-1]?[0-9]|2[0-3]):[0-5][0-9]?)$/';
        return preg_match($pattern, $value['opening_time']) && preg_match($pattern, $value['closing_time']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid time format';
    }
}
