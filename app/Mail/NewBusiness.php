<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewBusiness extends Mailable
{
  use Queueable, SerializesModels;
  public $id;
  public $name;
  public $business;
  public $email;
  public $evidence;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($id, $name, $business, $email, $evidence, $path)
  {
    $this->id = $id;
    $this->name = $name;
    $this->business = $business;
    $this->email = $email;
    $this->evidence = $evidence;
    $this->path = $path;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->from('partner@orderall.io')
      ->subject('Business signup request: ' . $this->business)
      ->view('mail.business-signup')
      ->attach($this->path,  [
        'as' => $this->evidence->getClientOriginalName(),
        'mime' => $this->evidence->getClientMimeType(),
      ]);
  }
}
