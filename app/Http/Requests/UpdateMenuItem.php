<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Storage;

class UpdateMenuItem extends FormRequest
{

    public function __construct(){
        // in case someone would like to set business_id manually
        request()->request->remove('business_id');

        if(isset(request()->image) && Storage::exists(request()->image)){
            request()->request->remove('image');
        } else {
            request()->request->add(['image' => '']);
        }
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
          'category' => 'required|string|max:25|regex:/[A-Za-z0-9. -&]/'
      ];
    }
}
