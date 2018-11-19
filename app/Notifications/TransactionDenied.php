<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Mail\TransactionDenied as TransactionMail;

class TransactionDenied extends Notification
{
    use Queueable;
    public $transaction;
    public $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction, $reason)
    {
        $this->transaction = $transaction;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
        //return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      return (new TransactionMail($this->transaction, $this->reason))->to($this->transaction->user->email);
    }

    public function toWebPush($notifiable)
    {
      return (new WebPushMessage)
          ->title('Order denied')
          ->icon('/android-chrome-512x512.png')
          ->body('Unfortunately, your order has been denied. ' . $this->reason)
          ->vibrate();
      }
}
