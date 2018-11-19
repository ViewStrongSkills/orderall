<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\OperatingHour;
use App\Rules\OperatingHours\OhRequired;
use App\Rules\OperatingHours\OhFormat;
use App\Rules\OperatingHours\OhRange;

class UpdateMenu extends FormRequest
{

    public function __construct(){

        if (isset(request()->operatinghours)) {
            request()->request->add([
                'operatinghours' => OperatingHour::prepare(request()->operatinghours),
            ]);
        }

        request()->request->remove('main');
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
        $rules = [
          'name' => 'required|string|regex:/^[a-z\d\-_\s-]+$/i|max:100',
          'operatinghours.*' => ['bail', new OhRequired, new OhFormat, new OhRange],
        ];
        if (!$this->menu->main) {
            $rules['operatinghours'] = ['array','required'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
           'operatinghours.*' => 'Operating hours are required.',
        ];
    }


}
