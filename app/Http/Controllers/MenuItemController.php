<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\CartItem;
use App\Business;
use App\Http\Requests\StoreMenuItem;
use App\Http\Requests\UpdateMenuItem;
use Illuminate\Http\Request;
use Session;
use View;
use Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MenuItemController extends BaseController
{
    public function show($business, $menuitemid)
    {
        $menuitem = MenuItem::find($menuitemid);
        return view('businesses.menuitem-modal')
        ->withElement($menuitem)
        ->withBusiness($menuitem->menu->business)
        ->withTitle($menuitem->name);
    }

    public function reviews(Business $business, Menuitem $menuitem, Request $request)
    {
      $reviews = $menuitem->reviews()->latest()->paginate(10);
      if(request()->ajax())
      {
        return view('reviews.review-modal')
          ->withAction('index')
          ->withMenuitem($menuitem)
          ->withBusiness($business)
          ->withAjax(true)
          ->withReviews($reviews)
          ->withTitle('View reviews for ' . $menuitem->name);
      }

      return view('reviews.indexitem')
        ->withReviews($reviews)
        ->withBusiness($business)
        ->withMenuitem($menuitem);
    }

    public function create(Business $business)
    {
      if (!Auth::user()->business && !Auth::user()->hasRole(['Developer'])) {
        flash()->success('Please, create a Business first!');
        return redirect(route('businesses.create'));
      }

      if(request()->ajax()){
        return view('menuitems.modal-form-menuitem')
          ->withAction('create')
          ->withBusiness($business)
          ->withAjax(true)
          ->withTitle('Add a new Menu Item');
      }

      return view('menuitems.create')
        ->withAjax(request()->ajax())
        ->withBusiness($business);
    }

    public function store(Business $business, StoreMenuItem $request)
    {

      $menuitem = MenuItem::create($request->all());

      if ($request->ajax()) {
        $business->load('menuswithitems');
        return view('businesses.menu')
          ->withUserTransactionItems(Auth::user()->transaction_items->pluck('menu_item_id'))
          ->withBusiness($business);
      }

      flash()->success('Successfully created menu item!');
      return redirect(route('businesses.show', $business->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business, MenuItem $menuitem)
    {

      if(request()->ajax()){
        return view('menuitems.modal-form-menuitem')
          ->withAction('edit')
          ->withMenuitem($menuitem)
          ->withBusiness($business)
          ->withAjax(true)
          ->withTitle('Edit '.$menuitem->name);
      }

      return view('menuitems.edit')
        ->withAjax(false)
        ->withBusiness($business)
        ->withMenuitem($menuitem);
    }

    public function update(Business $business, MenuItem $menuitem, UpdateMenuItem $request)
    {
      $menuitem->cartextras()->delete();
      $menuitem->cartitems()->delete();
      $menuitem->update($request->all());

      if ($request->ajax()) {
        $business->load('menuitems');
        return view('businesses.menu')
          ->withUserTransactionItems(Auth::user()->transaction_items->pluck('menu_item_id'))
          ->withBusiness($business);
      }
      flash()->success('Successfully updated menu item!');
      return redirect(route('businesses.show', $menuitem->menu->business->id));
    }

    public function destroy(Business $business, MenuItem $menuitem)
    {
      $menuitem->cartextras()->delete();
      $menuitem->cartitems()->delete();
      $menuitem->extras()->delete();
      $menuitem->delete();

      flash()->success('Successfully deleted the menu item!');
      return redirect(route('businesses.show', $business->id));
    }
}
