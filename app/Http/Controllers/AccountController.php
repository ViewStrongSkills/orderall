<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Cart;
use Redirect;
use Session;
use Mail;
use Mapper;
use DB;
use App\Business;
use App\PhoneVerification;
use \Carbon\Carbon;
use URL;
use App\Mail\AccountUpdated;

class AccountController extends BaseController
{

	public function __construct()
	{
			$this->middleware('auth');
	}

		public function index()
		{
			return $this->show(Auth::user());
		}

    public function reviews()
    {
      $reviews = Auth::user()->reviews()->latest()->paginate(10);
      return view('users.reviews', ['reviews' => $reviews]);
    }

    public function show()
    {
			$user = Auth::user();
			if (!$user) {
				return redirect('login');
			}
      return view('users.show')
      	->withUser($user);
    }

    public function destroy()
    {
    	if (!Auth::user()->deleteable) {
        flash()->error('Can not delete this account');
        return response()->view('errors.403', [], 403);
    	}

      Auth::user()->delete();
      flash()->success('Successfully deleted account!');
      return redirect(route('home'));
    }

		public function confirm($businessid)
		{
			$business = Business::find($businessid);
			$cart = Cart::where('business_id', $businessid)->where('user_id', Auth::user()->id)->first();
			Mapper::map($business->latitude, $business->longitude, ['zoom' => 15, 'marker' => false, 'eventBeforeLoad' => 'addMapStyling(map);'])->informationWindow($business->latitude, $business->longitude, '<p><strong>' . $business->name . '</strong><br />' .  $business->addressLine1 . '<br />' . $business->addressLine2 . '<br />' . $business->locality . '</p>', ['open' => true, 'markers' => ['animation' => 'DROP']]);
			if ($cart && $cart->orderable) {
				return view('confirmorder', $data = ['confirmpage' => true, 'user' => Auth::user(), 'cart' => $cart, 'businessid' => $businessid]);
			}
			else {
				return redirect(URL::to('/businesses/' . $businessid));
			}
		}

		public function updatephone(Request $request)
		{
			$validatedData = $request->validate([
			'phone' => 'required|unique:users|phone:AU,mobile',
			]);
			$messages = [
				 'phone.phone' => 'The phone number must be a valid Australian phone number.',
			];
			$code = mt_rand(0, 9999);
			$verification = new PhoneVerification;
			$verification->code = $code;
			$verification->phone = $request->input('phone');
			$verification->user_id = Auth::id();
			$verification->created_at = Carbon::now();
			$verification->save();
			$client = new \Twilio\Rest\Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
			$message = $client->messages->create($request->input('phone'), array('from' => 'Orderall', 'body' => 'Your ' . config('app.name') . ' code is ' . $code, 'MaxPrice' => '0.10')); //sends twilio message
			return Redirect::to('/updatephone/send');
		}

		public function checkphone(Request $request)
		{
			$user = Auth::user();
			$verification = PhoneVerification::where('user_id', $user->id)->latest()->first();
			if ($request->input('code') == $verification->code) {
				$user->phone = $verification->phone;
				$user->save();
				PhoneVerification::where('user_id', $user->id)->delete();
				$user->notify(new PhoneAdded($user));
				flash()->success('A phone number has successfully been added to your account!');
				return Redirect::to('/account/');
			}
			else
			{
				flash()->error('The number you entered doesn\'t match ours.');
				return Redirect::to('/updatephone/send');
			}
		}
}
