<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Role;

class UserUpdateRequest extends FormRequest
{

    public function __construct(\Illuminate\Http\Request $request){
        if(empty($request->password)){
            $request->request->remove('password');
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user->developer)
            return false;

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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'role' => 'required|exists:roles,id|not_in:'.Role::where('name', 'Developer')->first()->id,
            'password' => 'sometimes|required|confirmed',
            'current_user_password' => 'required|password_match:' . Auth::user()->password,
        ];
    }
}
