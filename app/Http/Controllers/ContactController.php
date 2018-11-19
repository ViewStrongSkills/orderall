<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendContact;
use Mail;
use Redirect;

class ContactController extends Controller
{
    public function view()
    {
      return view('contact');
    }

    public function send(Request $request)
    {
      $request->validate([
        'email' => ['required', 'email', 'max:100'],
        'subject' => ['required', 'string', 'max:200'],
        'content' => ['required', 'string', 'max:5000'],
        'first_name' => ['required', 'string', 'max:200'],
        'last_name' => ['required', 'string', 'max:200']
       ]);

      Mail::to('contact@orderall.io')->send(new SendContact($request['email'], $request['subject'], $request['content'], $request['first_name'] . ' ' . $request['last_name']));
      flash()->success('Your message has been sent.');
      return Redirect::to('/contact');
    }
}
