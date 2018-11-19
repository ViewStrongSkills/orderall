<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Role;
use App\User;

class ToggleUserRoleRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|not_in:'.implode(',', User::developers()->pluck('id')->toArray()),
            'role_id' => 'required|exists:roles,id|not_in:'.Role::where('name', 'Developer')->first()->id,
        ];
    }
}
