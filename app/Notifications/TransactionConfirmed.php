<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Mail\TransactionConfirmed as TransactionMail;

class TransactionConfirmed extends Notification
{
    use Queueable;
    public $transaction;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
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
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      return (new TransactionMail($this->transaction))->to($this->transaction->user->email);
    }

    public function toWebPush($notifiable)
    {
      return (new WebPushMessage)
          ->title('Order confirmed!')
          ->icon('/android-chrome-512x512.png')
          ->body('Your order has been confirmed!')
          //->action('View account', 'view_account');
          // ->data(['id' => $notification->id])
          // ->badge()
          // ->dir()
          // ->image()
          // ->lang()
          // ->renotify()
          // ->requireInteraction()
          //->tag()
          ->vibrate()
      }
}
