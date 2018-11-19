<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionDenied extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction;
    public $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction, $reason)
    {
        $this->transaction = $transaction;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('orders@orderall.io')->subject('Your Orderall transaction has been denied')->view('mail.transactiondenied');
    }
}
