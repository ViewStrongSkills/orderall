<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\OperatingHour;
use Storage;
use App\Rules\OperatingHours\OhRequired;
use App\Rules\OperatingHours\OhFormat;
use App\Rules\OperatingHours\OhRange;
use Auth;
use App\Business;

class UpdateBusiness extends FormRequest
{

  public function __construct(){

    request()->request->add(['operatinghours' => OperatingHour::prepare(request()->operatinghours)]);

    if(isset(request()->imagedl) && Storage::exists(request()->imagedl)){
        request()->request->remove('imagedl');
    } else {
        request()->request->add(['imagedl' => '']);
    }

  }


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
        'name' => 'nullable|regex:/^[a-z\d\-_\s-]+$/i|max:100',
        'phone' => 'nullable|phone:AU,fixed_line',
        'addressLine1' => 'nullable|max:100',
        'addressLine2' => 'nullable|max:100',
        'email' => 'nullable|email|max:50',
        'website' => 'nullable|url|max:100',
        'locality' => 'nullable|regex:/^[a-z\d\-_\s-]+$/i|max:50',
        'postcode' => 'nullable|numeric|digits:4',
        'tags' => 'required|array',
        'tags.*' => 'required|regex:/^[a-z\d\-_\s-]+$/i|max:100', //regex for only alpha + spaces + dash
        'latitude' => 'nullable|numeric|max:9999.999999',
        'longitude' => 'nullable|numeric|max:9999.999999',
        'imagedl' => 'nullable|image|max:2048|mimes:jpeg,bmp,png', //limits image to 2mb
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
     'locality.regex' => 'The locality may only contain letters, numbers, spaces and dashes.'
    ];
  }

}
