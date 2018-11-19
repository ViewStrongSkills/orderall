<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreReview extends FormRequest
{

    public function __construct(){
      request()->request->add(['user_id' => Auth::user()->id]);
    }

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
          'rating' => 'required|numeric|min:0|max:100',
          'content' => 'required|string|max:255',
          'menu_item_id' => 'required|exists:menu_items,id',
        ];
    }
}
