<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Business;
use App\Transaction;
use App\OperatingHour;
use App\Cart;
use App\Tag;
use App\MenuExtra;
use App\TransactionItem;
use App\Menu;
use App\Http\Requests\StoreBusiness;
use App\Http\Requests\UpdateBusiness;
use Session;
use Redirect;
use Mapper;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class BusinessController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if (!$request->search) {
        return Redirect::to('/');
      }

      $search = $request->search;
      $current_day = (Carbon::now()->format('N')) - 1;
      $current_time = Carbon::now()->toTimeString();
      //$result = Business::where('name', 'LIKE', "%$search%")->join('operating_hours', 'businesses.id', '=', 'operating_hours.entry_id')->select('businesses.*', 'operating_hours.opening_time','operating_hours.closing_time')->where('operating_hours.day','=',$current_day)->where('operating_hours.opening_time','<',$current_time)->where('operating_hours.closing_time','>',$current_time)->paginate(3)->appends(Input::except('page'));
      $result = Business::search('name', $search)->inRadius($request->xcoord, $request->ycoord, $request->radius)->paginate(3)->appends(Input::except('page'));
      BusinessController::getDistanceFromUser($result, $request->xcoord, $request->ycoord);

      $view = 'businesses.search';
      if($request->ajax() && $request->has('search')){
        $view = 'businesses.searchresults';
      }

      return view($view, ['xcoord' => $request->xcoord, 'ycoord' => $request->ycoord, 'addresssearch' => false])
        ->withSearchresults($result)
        ->withSearch($request->search)
        ->withRadius($request->radius)
        ->withAjax($request->ajax());
    }

    public function getDistanceFromUser($result, $xcoord, $ycoord)
    {
      foreach ($result as &$result_item) {

        $latFrom = ($xcoord);
        $lonFrom = ($ycoord);
        $latTo = ($result_item->latitude);
        $lonTo = ($result_item->longitude);

        $theta = $lonFrom - $lonTo;
        $dist = sin(deg2rad($latFrom)) * sin(deg2rad($latTo)) +  cos(deg2rad($latFrom)) * cos(deg2rad($latTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $result_item['distance'] = round($miles * 1.609344,2). 'km';
      }
    }

    public function transactions(Business $business)
    {
      $transactions = $business->transactions()->latest()->simplePaginate(25);

      return view('businesses.transactions')
        ->withBusiness($business)
        ->withTransactions($transactions);
    }

    public function transaction(Business $business, Transaction $transaction)
    {
      return view('businesses.transaction')
        ->withTransaction($transaction);
    }

    public function tags(Tag $tag, Request $request)
    {
      $xcoord = session('xcoord');
      $ycoord = session('ycoord');
      $result = $tag->businesses()->open()->inRadius($xcoord, $ycoord, 30)->simplePaginate(10);

      if (session('xcoord')) {
        BusinessController::getDistanceFromUser($result, $xcoord, $ycoord);
      }

      $view = 'businesses.tags';
      $ajax = false;
      if($request->ajax()){
        $view = 'businesses.searchresults';
        $ajax = true;
      }

      return view($view)
        ->withSearchresults($result)
        ->withTag($tag)
        ->withAjax($ajax);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // If User already has business
      if (Auth::user()->business && !Auth::user()->hasRole(['Admin', 'Developer'])) {
        flash()->error('Your business is already exists');
        return view('businesses.show', Auth::user()->business->id);
      }

      Mapper::map(-37.813600, 144.963100, ['zoom' => 10, 'draggable' => true, 'title' => 'Your business\'s location',
      'eventDragEnd' =>
        'document.getElementById("latitude").value = this.getPosition().lat();
         document.getElementById("longitude").value = this.getPosition().lng();']);
      return view('businesses.create')
        ->withTags(Tag::mostUsed(50));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusiness $request)
    {

      $user = Auth::user();

      // If User already has business
      if ($user->business_id && !$user->hasRole(['Admin', 'Developer'])) {
        flash()->error('Your business is already exists');
        return view('businesses.show', $user->business_id);
      }

      $business = Business::create($request->all());

      flash()->success('Successfully created business!');
      return redirect(route('businesses.show', $business->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
      $business->load('menuswithitems', 'menuitemreviews');

      Mapper::map($business->latitude, $business->longitude, ['zoom' => 15, 'marker' => false, 'eventBeforeLoad' => 'addMapStyling(map);'])->informationWindow($business->latitude, $business->longitude, '<p><strong>' . $business->name . '</strong><br />' .  $business->addressLine1 . '<br />' . $business->addressLine2 . '<br />' . $business->locality . '</p>', ['open' => true, 'markers' => ['animation' => 'DROP']]);

      $description = 'Pick and collect food from ' . $business->name . ' via Orderall. ' . $business->addressLine1 . ' ' . $business->addressLine2 . ' ' . $business->locality . '.';

      $keywords = "";

      foreach ($business->tags as $tag => $value) {
        $keywords .= $value->name;
        if ($tag != count($business->tags) - 1) {
          $keywords .= ',';
        }
      }

      if (Auth::check()) {
        $cart = Cart::where('business_id', $business->id)->where('user_id', Auth::user()->id)->first();
        return view('businesses.show', ['description' => $description, 'keywords' => $keywords])
          ->withBusiness($business)
          ->withCart($cart)
          ->withUserTransactionItems(Auth::user()->transaction_items->pluck('menu_item_id'))
          ->withOpen(true/*BusinessController::getopen($id)*/);
      }
      return view('businesses.show', ['description' => $description, 'keywords' => $keywords])
        ->withBusiness($business)
        ->withOpen(true/*BusinessController::getopen($id)*/);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business, Request $request)
    {
      Mapper::map($business->latitude, $business->longitude, ['zoom' => 10, 'draggable' => true, 'title' => 'Your business\'s location',
      'eventDragEnd' =>
        'document.getElementById("latitude").value = this.getPosition().lat();
         document.getElementById("longitude").value = this.getPosition().lng();']);

      return view('businesses.edit')
        ->withTags(Tag::mostUsed(50))
        ->withBusiness($business);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Business $business, UpdateBusiness $request)
    {
      $business->update($request->all());

      // redirect
      flash()->success('Successfully updated business!');
      return redirect(route('businesses.show', $business->id));
    }

    public function destroy(Business $business)
    {
      $business->transactions()->delete();
      $business->carts()->delete();
      $business->menuitems()->delete();
      $business->menus()->delete();
      $business->delete();

      flash()->success('Successfully deleted business!');
      return redirect(route('home'));
    }


    public function getopen($businessId)
    {
      $currentDay = Carbon::now()->dayOfWeekIso - 1; //returns the day of the week with Monday as 1 and Sunday as 7, so minus 1 for this system
      $operatingHour = OperatingHour::where('business_id', $businessId)->where('day', $currentDay)->get()->first();
      if ($operatingHour) {
        if ((Carbon::now() > $operatingHour->opening_time) && (Carbon::now() < $operatingHour->closing_time)) {
          return true;
        }
        return false;
      }
      return false;
    }

    public function getdays($id)
    {
      $days = [];
      for ($i=0; $i < 7; $i++) {
        $day = OperatingHour::where('business_id', $id)->where('day', $i)->get()->first();
        array_push($days, $day);
      }
      return $days;
    }
}
