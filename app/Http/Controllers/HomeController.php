<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function main()
    {
      if (geoip(\Request::ip())->iso_code != 'AU') {
        $unsupported = true;
      }
      else {
        $unsupported = false;
      }

        return view('main', ['unsupported' => $unsupported]);
    }

    public function index()
    {
        return Redirect::to('/');
    }

    public function unsupportedcountrynotice()
    {
      return view('countrywarning.modal-country-warning')->withTitle('Warning');
    }

    public function getaddresscoords(Request $request)
    {
      if (!$request->address) {
        return 'ERROR: no address specified in request';
      }
      $client = new \GuzzleHttp\Client();
      $result = json_encode(array('status' => false));
      $reqres = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $request->address . ',australia' . '&key=' . env('GOOGLE_API_KEY'));
      try {
        $location = (json_decode($reqres->getBody()))->results[0];
        if ($location->address_components[0]->types[0] == 'locality') {
          $result = json_encode(array('status' => true, 'lat' => $location->geometry->location->lat, 'lng' => $location->geometry->location->lng, 'format_add' => $location->address_components[0]->short_name));
        }
        else {
          $result = json_encode(array('status' => true, 'lat' => $location->geometry->location->lat, 'lng' => $location->geometry->location->lng, 'format_add' => $location->formatted_address));
        }
        session(['xcoord' => $location->geometry->location->lat]);
        session(['ycoord' => $location->geometry->location->lng]);
      }
      catch (\Exception $e) {
        return $result;
      }
      return $result;
    }
}
