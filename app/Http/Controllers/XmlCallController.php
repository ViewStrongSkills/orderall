<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Controllers\TransactionController;
use \Twilio\Security\RequestValidator;

class XmlCallController extends Controller
{
    public function maincall($id)
    {
      $postVars = $_POST;
      $validator = new RequestValidator(env('TWILIO_AUTH_TOKEN'));
      $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; //returns URL
      $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

      if ($validator->validate($signature, $url, $postVars)) {
        $order = TransactionController::writeorder(Transaction::find($id));
        $response = view('xml.call', ['order' => $order, 'id' => $id]);
        return response($response)->withHeaders([
              'Content-Type' => 'text/xml'
          ]);
      }
      else {
        return 'ERROR: did not validate';
      }
    }

    public function calldeclined()
    {
      $postVars = $_POST;
      $validator = new RequestValidator(env('TWILIO_AUTH_TOKEN'));
      $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

      if ($validator->validate($signature, $url, $postVars)) {
        $response = view('xml.declineoptions');
        return response($response)->withHeaders([
              'Content-Type' => 'text/xml'
          ]);
      }
      else {
        return 'ERROR: did not validate';
      }
    }
}
