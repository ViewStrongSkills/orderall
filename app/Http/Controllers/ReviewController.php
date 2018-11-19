<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\MenuItem;
use App\Business;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Http\Requests\StoreReview;

class ReviewController extends Controller
{

    public function create(Business $business, MenuItem $menuitem)
    {
      if (request()->ajax()) {
        return view('reviews.modal-form-create')
          ->withAction('create')
          ->withBusiness($business)
          ->withMenuitem($menuitem)
          ->withAjax(true)
          ->withTitle('Add a new review for ' . $menuitem->name);
      }
      return view('reviews.create')
        ->withBusiness($business)
        ->withMenuitem($menuitem);
    }

    public function store(Business $business, MenuItem $menuitem, StoreReview $request)
    {
      $review = $menuitem->reviews()->create($request->all());

      flash()->success('Successfully created review!');
      return redirect(route('businesses.show', [$business->id, '#'.$menuitem->id]));
    }

}
