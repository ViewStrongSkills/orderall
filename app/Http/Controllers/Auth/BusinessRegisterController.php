<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Session;
use App\Mail\AccountConfirm;
use App\Mail\NewBusiness;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\BusinessRegistered;

class BusinessRegisterController extends Controller
{
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.business');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $file = $request->file('business-evidence');
        $user = $this->create($request->all(), $file);
        // event(new BusinessRegistered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|alpha|string|max:50',
            'last_name' => 'required|alpha|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|max:255|confirmed',
            'business_name' => 'required|string|max:100',
            'business-evidence' => 'required|file|max:2048',
            'tos' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, $file)
    {
        $path = 'upload/business';

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        $fileName = $file->getClientOriginalName();
        $file->move(public_path($path), $fileName);

        $data['unsub_token'] = 'error';
        $user = User::create([
            'first_name' => ucfirst($data['first_name']),
            'last_name' => ucfirst($data['last_name']),
            'email' => $data['email'],
            'email_token' => 'error',
            'unsub_token' => $data['unsub_token'],
            'password' => Hash::make($data['password']),
        ]);

        $user->unsub_token = md5($user->id) . str_random(32);
        $user->email_token = md5($user->id) . str_random(32);
        $user->save();
        $user->attachRole(5);
        Session::flash('message', 'Your account has been created! You will recieve an email when we\'ve verified your details.');

        Mail::to('partner@orderall.io')->send(new NewBusiness($user->id, $user->name, $data['business_name'], $user->email, $data['business-evidence'], $path));
        return $user;
    }
}
