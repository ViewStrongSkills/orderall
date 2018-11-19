<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Session;
use App\Mail\AccountConfirm;
use Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data += array('ip' => request()->ip());
        return Validator::make($data, [
            'first_name' => 'required|alpha|string|max:50',
            'last_name' => 'required|alpha|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|max:255|confirmed',
            'ip' =>  ['max:40',
                    function ($attribute, $value, $fail) {
                    if (geoip($value)->iso_code != 'AU') {
                        $fail('Orderall currently only supports Australian accounts.');
                    }
                },
            ],
            'tos' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => ucfirst($data['first_name']),
            'last_name' => ucfirst($data['last_name']),
            'email' => $data['email'],
            'email_token' => 'error',
            'unsub_token' => 'error',
            'password' => Hash::make($data['password']),
        ]);
        $user->unsub_token = md5($user->id) . str_random(32);
        $user->email_token = md5($user->id) . str_random(32);
        $user->save();
        $user->attachRole(5);
        Session::flash('message', 'Your account has been created! Please check your email for the confirmation link.');
        Mail::to($user)->send(new AccountConfirm($user));
        return $user;
    }
}
