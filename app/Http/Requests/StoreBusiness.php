<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\OperatingHour;
use App\Rules\OperatingHours\OhRequired;
use App\Rules\OperatingHours\OhFormat;
use App\Rules\OperatingHours\OhRange;
use Auth;

class StoreBusiness extends FormRequest
{

    public function __construct(\Illuminate\Http\Request $request){
      $request->request->add(['operatinghours' => OperatingHour::prepare($request->operatinghours)]);
    }



    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if (Auth::user()->canCreateBusiness())
      {
        return true;
      }
      return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|string|regex:/^[a-z\d\-_\s-]+$/i|max:100',
          'phone' => 'required|phone:AU,fixed_line',
          'addressLine1' => 'nullable|string|max:100',
          'addressLine2' => 'required|string|max:100',
          'email' => 'nullable|string|email|max:100',
          'website' => 'nullable|string|url|max:100',
          'locality' => 'required|string|regex:/^[a-z\d\-_\s-]+$/i|max:50',
          'postcode' => 'required|numeric|digits:4',
          'tags' => 'required|array',
          'tags.*' => 'required|regex:/^[a-z\d\-_\s-]+$/i|max:100', //regex for only alpha + spaces + dash
          'latitude' => 'required|numeric|max:9999.999999',
          'longitude' => 'required|numeric|max:9999.999999',
          'business-tos' => 'required',
          'imagedl' => 'required|image|max:2048|mimes:jpeg,bmp,png', //limits image to 2mb
          'operatinghours.*' => ['bail', new OhRequired, new OhFormat, new OhRange],
        ];
    }

    public function messages()
    {
      return [
       'name.regex' => 'The name may only include letters, numbers, spaces and dashes.',
       'phone.phone' => 'The phone number must be a valid Australian fixed line phone number.',
       'tags.regex' => 'The tags may only contain letters, spaces and dashes.',
       'operatinghours.*' => 'The operating hours must be formatted correctly.',
       'latitude.required' => 'You must set your business\'s location on the map.',
       'longitude.required' => 'You must set your business\'s location on the map.',
       'imagedl.required' => 'You must add an image to the business.',
       'imagedl.dimensions' => 'The image must be cropped to a ratio of 7:4.',
       'imagedl.max' => 'The image may not be over two megabytes in size.',
       'imagedl.mimes' => 'The image may only be in the JPEG, BMP or PNG file formats.',
       'business-tos.required' => 'You must agree to the Business Terms of Service.',
       'addressLine2.required' => 'The second address line is required.',
       'locality.regex' => 'The locality may only contain letters, numbers, spaces and dashes.'
      ];
    }
}
