<?php

namespace App\Rules\OperatingHours;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class OhRange implements Rule
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
        $ot = explode(':', $value['opening_time']);
        $ct = explode(':', $value['closing_time']);
        $opening = Carbon::now()->setTime($ot[0], $ot[1]);
        $closing = Carbon::now()->setTime($ct[0], $ct[1]);
        return $closing->gt($opening);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The closing time is earlier than the opening time';
    }
}
