<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class MenuExtraCategoryUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($entry_id=null, $menuitem_id=null)
    {
        $this->entry_id = $entry_id;
        $this->menuitem_id = $menuitem_id;
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
        // editing entry
        if ($this->entry_id) {
            $sql = sprintf(
                'SELECT * FROM menu_extra_categories WHERE name = "%s" AND id != %d AND menu_item_id = "%s" LIMIT 1',
                $value,
                $this->entry_id,
                $this->menuitem_id
            );
        // creating entry
        } else {
            $sql = sprintf(
                'SELECT * FROM menu_extra_categories WHERE name = "%s" AND menu_item_id = "%s" LIMIT 1',
                $value,
                $this->menuitem_id
            );
        }

        $result = DB::select($sql);            

        if(empty($result))
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The category with this name already exists.';
    }
}
