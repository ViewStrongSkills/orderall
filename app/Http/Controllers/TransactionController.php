<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\CartItem;
use App\CartExtra;
use App\User;
use App\Business;
use App\Transaction;
use App\TransactionItem;
use App\TransactionExtra;
use Illuminate\Support\Facades\Auth;
use URL;
use Mail;
use Redirect;
use \Twilio\Rest\Client;
use \Twilio\Security\RequestValidator;
use \Twilio\Twiml;
use App\Notifications\TransactionConfirmed;
use App\Notifications\TransactionDenied;

class TransactionController extends Controller
{
    public static function writeorder($transaction)
    {
      $message = 'Hello, this is an automatic message via Orderall for the business ' . $transaction->business->name . '.
                  Order for user: ' . $transaction->user->first_name . ' ' . $transaction->user->last_name . ' of: ';
      for ($i=0; $i < $transaction->items->count(); $i++) {
        $message .= 'item '. $transaction->items[$i]->item->name;

        if ($transaction->items[$i]->extras->count() > 0) {
          $message .= ' with ';

          for ($j=0; $j < $transaction->items[$i]->extras->count(); $j++) {
            $message .= $transaction->items[$i]->extras[$j]->extra->name;

            if ($j == $transaction->items[$i]->extras->count() - 2) {
               $message .= ' and ';
            }

            else if ($j == $transaction->items[$i]->extras->count() - 1) {
               $message .= '';
            }

            else {
               $message .= ', ';
            }
          }

        }
        if ($transaction->items[$i]->comments) {
          $message .= '. Additional requests or comments for this item: ' . $transaction->items[$i]->comments . '. ';
        }
        if ($i == $transaction->items->count() - 2) {
          $message .= ' and ';
        }

        else if ($i == $transaction->items->count() - 1)
        {
          $message .= '.';
        }
        else {
          $message .= ', ';
        }
      }
      $message .= ' Total price: $' . $transaction->price . '. User I.D.: ' . $transaction->user_id . '.
                  Order I.D.: ' . $transaction->id . '.' . ' Order made on: ' . date('l \t\h\e jS \o\f F Y \a\t g\:ia', strtotime($transaction->created_at)) . '.';
      return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        return view('users.transaction')->with('transaction', $transaction);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $transactions = Auth::user()->transactions()->with('business')->latest()->paginate(10);
      return view('users.transactions')
        ->withTransactions($transactions);
    }

    public function checknotifications()
    {
      if (Auth::user()->transactions()->latest()->first()) {
        $transaction = Auth::user()->transactions()->latest()->first();
        if (($transaction->status != 'pending') && (!$transaction->notification_seen)) {
          $transaction->notification_seen = true;
          $transaction->save();
          return view('partials.order-notify', ['transaction' => $transaction]);
        }
      }
      return null;
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //sends confirmation email, makes call, clears user's cart
    public function store(Request $request)
    {

      $user = Auth::user();

      if(false === $user->canMakeTransaction()){
        flash()->error('Only one transaction per two minutes allowed');
        return back();
      }

      $cart = Cart::where('business_id', $request->input('business_id'))->where('user_id', $user->id)->first();

      if (!$cart) {
        return Redirect::to('/');
      }

      //if(!$cart->orderable){
        // error 'You must choose required extras'
        //return back();
      //}

      if (!Business::open()->find($cart->business_id)) {
        flash()->error('This restaurant is currently closed');
        return redirect(URL::to('confirm'));
      }

      if (($cart->cartitems->sum('menuitem.price')) > 999.99) {
        flash()->error('Transactions may not be more than $1000');
        return redirect(URL::to('confirm'));
      }

      //adds to direct payment sum
      $directPaymentSum = 0;
      foreach ($cart->cartitems as $key => $value) {
        if ($value->menuitem->menu->business->supports_payment) {
          $directPaymentSum += $value->menuitem->price;
          $directPaymentSum += $value->cartextras->sum('menuextra.price');
        }
      }

      //check if direct payment sum is more than account balance
      if ($directPaymentSum > $user->acc_balance) {
        return redirect(URL::to('confirm'));
      }

      //subtract direct payment from balance
      $user->acc_balance -= $directPaymentSum;

      //get total price
      $price = $cart->cartitems->sum('menuitem.price');
      $price -= $cart->cartitems->sum('menuitem.discount');
      $price += $cart->cartextras->sum('menuextra.price');

      //set fields of transaction
      $transaction = new Transaction;
      $transaction->user_id = $user->id;
      $transaction->business_id = $cart->business_id;
      $transaction->price = $price;

      $transaction->save();

      //adds transaction items for each cart item
      foreach ($cart->cartitems as $cartitem) {

        $transaction_item = TransactionItem::create([
          'transaction_id' => $transaction->id,
          'menu_item_id' => $cartitem->menuitem->id,
          'price' => $cartitem->menuitem->price,
          'discount' => $cartitem->menuitem->discount,
          'name' => $cartitem->menuitem->name,
          'comments' => $cartitem->comments,
        ]);

        foreach ($cartitem->cartextras as $cartextra) {
          $transaction_extra = TransactionExtra::create([
            'menu_extra_id' => $cartextra->menuextra->id,
            'name' => $cartextra->menuextra->name,
            'price' => $cartextra->menuextra->price,
            'transaction_item_id' => $transaction_item->id,
          ]);
        }
      }

      $cart->cartextras()->delete();
      $cart->cartitems()->delete();
      $cart->delete();

      $phone_to = $transaction->business->phone_country_code . (ltrim($transaction->business->phone, '0'));
      $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
      $client->account->calls->create(
          $phone_to,
          env('TWILIO_FROM_LANDLINE'),
          array(
              "statusCallback" => URL::to('api/completetransaction/' . $transaction->id),
              "timeout" => "60",
              "url" => URL::to('api/callmain/' . $transaction->id . '.xml')
          )
      );
      return view('finish');
    }

    public function complete($id, Request $request)
    {
      $postVars = $_POST;
      $validator = new RequestValidator(env('TWILIO_AUTH_TOKEN'));
      $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

      if ($validator->validate($signature, $url, $postVars)) {
        $transaction = Transaction::find($id);
        $response = view('xml.hangup');
        if ($transaction->status != 'pending') { //check that the transaction can actually be set
          return;
        }
        $user = $transaction->user;
        if ($request->input('Digits') == 1) {
          $transaction->status = 'accepted';
          $user->notify(new TransactionConfirmed($transaction));
          $transaction->save();
        }
        elseif ($request->input('Digits') == 2) {
          $response = view('xml.declineoptions', ['id' => $id]);
        }
        else {
          $response = TransactionController::sendDeclineMessage($user, $transaction, ' The business did not supply a reason.');
        }
        return $response->withHeaders([
          'Content-Type' => 'text/xml'
        ]);
      }
      else {
        return 'ERROR: did not validate';
      }
    }

    private function sendDeclineMessage($user, $transaction, $reason)
    {
      $response = view('xml.hangup');
      $transaction->status = 'declined';
      $transaction->declined_reason = $reason;
      $phonenum = $user->phone_country_code . (ltrim($user->phone, '0'));
      if ($user->phone) {
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        $content = 'Unfortunately your transaction has been declined by the business.' . $reason;
        $message = $client->messages->create($phonenum, array('from' => 'Orderall', 'body' => $content, 'MaxPrice' => '0.10'));
      }
      else {
        $user->notify(new TransactionDenied($transaction, $reason));
      }
      $transaction->save();
      return response($response);
    }

    public function declineWithReason($id, Request $request)
    {
      $postVars = $_POST;
      $validator = new RequestValidator(env('TWILIO_AUTH_TOKEN'));
      $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

      if ($validator->validate($signature, $url, $postVars)) {
        $transaction = Transaction::find($id);
        $user = $transaction->user;
        $reason = TransactionController::getreason($request->input('Digits'));
        return TransactionController::sendDeclineMessage($user, $transaction, ' The reason was: ' . $reason)->withHeaders([
          'Content-Type' => 'text/xml'
        ]);
      }
      else {
        return 'ERROR: did not validate';
      }
    }


    private function getreason($reasonnumber)
    {
      $reason = '';
        switch ($reasonnumber) {
          case 1:
            $reason .= 'The business is out of stock for an item.';
            break;
          case 2:
            $reason .= 'An item you ordered is not on the menu.';
            break;
          case 3:
            $reason .= 'There has been a wrong number called.';
            break;
          case 4:
            $reason .= 'Your order was too large.';
            break;
          case 5:
            $reason .= 'There was a non-specified reason.';
            break;
          default:
            $reason .= 'There was a non-specified reason.';
        break;
        }
      return $reason;
      }
}
