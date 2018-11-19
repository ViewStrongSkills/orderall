<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMenuItem extends FormRequest
{


    public function __construct(){
        request()->request->add(['business_id' => request()->route()->parameter('business')->id]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      // TODO: set correct check
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
          'name' => 'required|string|regex:/[A-Za-z0-9. -]/|max:50',
          'price' => 'required|numeric|max:999.99|min:0',
          'discount' => 'numeric|nullable|max:price|min:0.01|max:' . $this->get('price'), //checks that discount less than actual price
          'image' => 'nullable|image|max:512|mimes:jpeg,bmp,png', //limits to 512kb
          'description' => 'required|string|max:100',
          'category' => 'required|string|max:25|regex:/[A-Za-z0-9. -&]/',
          'business_id' => 'required|exists:businesses,id',
      ];
    }
}
