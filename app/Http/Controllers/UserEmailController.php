<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Redirect;
use Session;

class UserEmailController extends Controller
{
  public function authenticate($token)
  {
    $user = User::where('email_token', $token)->first();
    if (Auth::check() && Auth::user()->email_token != $token) {
      flash()->error('Your account could not be verified.');
      return Redirect::to('account');
    }
    if ($user) {
      DB::table('role_user')->where('role_user.user_id',$user->id)->delete();
      $user->attachRole(3);
      $user->save();
      flash()->success('Your account has been verified!');
    }
    else {
      flash()->error('Your account could not be verified.');
    }
    if (Auth::check()) {
      return Redirect::to('account');
    }
    else {
      return Redirect::to('/');
    }
  }

  public function subscribe()
  {
    $user = Auth::user();
    $user->subscribed = true;
    $user->save();
    flash()->success('You have been subscribed to Orderall emails.');
    return redirect::to('account');
  }

  public function unsubscribe($value)
  {
    $user = User::where('unsub_token', $value)->first();
    $user->subscribed = false;
    $user->save();
    flash()->success('You have been unsubscribed from Orderall emails.');
    if (Auth::check()) {
      return redirect::to('account');
    }
    else {
      return redirect::to('/');
    }
  }
}
