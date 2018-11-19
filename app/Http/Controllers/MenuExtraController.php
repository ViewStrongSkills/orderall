<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuExtra;
use App\Http\Requests\MenuExtraRequest;
use Illuminate\Http\Request;
use App\Business;
use App\MenuExtra;
use App\MenuItem;
use App\CartItem;
use Session;
use Illuminate\Support\Facades\Auth;
use Redirect;
use URL;
use View;

class MenuExtraController extends BaseController
{
    public function index(Business $business, MenuItem $menuitem)
    {
      $menuextras = $menuitem->extras;
      return view('menuextras.index')
        ->withBusiness($business)
        ->withMenuitem($menuitem)
        ->withMenuextras($menuextras);
    }

    public function create(Business $business, MenuItem $menuitem)
    {
      if (request()->ajax()) {
        return view('menuextras.modal-form-menuextra')
          ->withAction('create')
          ->withBusiness($business)
          ->withMenuitem($menuitem)
          ->withAjax(true)
          ->withTitle('Add a new Menu Extra');
      }

      return view('menuextras.create')
        ->withAjax(false)
        ->withBusiness($business)
        ->withMenuitem($menuitem);
    }

    public function store(Business $business, MenuItem $menuitem, StoreMenuExtra $request)
    {
      if ($request->category) {
        $category = $menuitem->manageCategories($request->category);
        $request['menu_extra_category_id'] = $category->id;
      }

      $extra = $menuitem->extras()->create($request->all());

      if (request()->ajax()) {
        return view('menuextras.list-item')
          ->withBusiness($business)
          ->withMenuitem($menuitem)
          ->withExtra($extra);
      }

      // redirect
      flash()->success('Successfully created menu extra for '.$menuitem->name.'!');
      return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextras'));
    }

    public function edit(Business $business, MenuItem $menuitem, MenuExtra $menuextra)
    {

      if(request()->ajax()){
        return view('menuextras.modal-form-menuextra')
          ->withAction('edit')
          ->withMenuextra($menuextra)
          ->withMenuitem($menuitem)
          ->withBusiness($business)
          ->withAjax(true)
          ->withTitle('Edit '.$menuitem->name);
      }

      return view('menuextras.edit')
        ->withAjax(false)
        ->withBusiness($business)
        ->withMenuitem($menuitem)
        ->withMenuextra($menuextra);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Business $business, MenuItem $menuitem, MenuExtra $menuextra, StoreMenuExtra $request)
    {
      foreach ($menuextra->cartextras() as $cartextra) {
        $cartextra->cartitem->cartextras()->delete();
      }
      $menuextra->cartextras()->delete();

      // $menuextra->item->cartitems()->delete();
      foreach ($menuextra->item->cartitems as $i) {
        $i->cartextras()->delete();
        $i->delete();
      }

      if ($request->category) {
        $category = $menuitem->manageCategories($request->category);
        $request['menu_extra_category_id'] = $category->id;
      }

      $menuextra->update($request->all());

      if (request()->ajax()) {
        return view('menuextras.list-item')
          ->withBusiness($business)
          ->withMenuitem($menuitem)
          ->withExtra($menuextra);
      }

      flash()->success('Successfully updated menu extra for '.$menuitem->name.'!');
      return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextras'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business, Menuitem $menuitem, MenuExtra $menuextra)
    {
      $menuextra->cartextras()->delete();
      $menuextra->delete();
      // redirect
      flash()->success('Successfully deleted the menu extra!');
      return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextras'));
    }
}
