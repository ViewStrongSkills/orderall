<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Business;
use App\MenuItem;
use App\MenuExtraCategory;
use App\Http\Requests\StoreMenuExtraCategory;
use Illuminate\Support\Facades\Auth;
use URL;

use App\Rules\MenuExtraCategoryUnique;

class MenuExtraCategoryController extends BaseController
{
  public function index(Business $business, MenuItem $menuitem, MenuExtraCategory $menuextracategory)
  {
    if (request()->ajax()) {
      return view('menuextracategories.modal-form-menuextracategory')
        ->withAction('index')
        ->withAjax(true)
        ->withTitle('Manage menu extra categories');
    }

    return view('menuextracategories.index')
      ->withAjax(false)
      ->withBusiness($business)
      ->withMenuitem($menuitem);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Business $business, MenuItem $menuitem)
     {
       if (request()->ajax()) {
         return view('menuextracategories.modal-form-menuextracategory')
           ->withAction('create')
           ->withBusiness($business)
           ->withMenuitem($menuitem)
           ->withAjax(true)
           ->withTitle('Add a new Menu Extra Category');
       }

       return view('menuextracategories.create')
         ->withAjax(false)
         ->withBusiness($business)
         ->withMenuitem($menuitem);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Business $business, MenuItem $menuitem, Request $request)
     {
       $request->validate([
         'name' => ['required', 'regex:/[A-Za-z0-9. -]/', 'max:100', new MenuExtraCategoryUnique(null, $menuitem->id)],
        ]);

        $menuextracategory = MenuExtraCategory::create([
          'name' => ucfirst($request['name']),
          'required' => $request->required,
          'menu_item_id' => $menuitem->id,
        ]);

        if (request()->ajax()) {
          return view('menuextracategories.list-item')
            ->withBusiness($business)
            ->withMenuitem($menuitem)
            ->withCategory($menuextracategory);
        }

       // redirect
       flash()->success('Successfully created menu extra category for '. $menuitem->name.'!');
       return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextracategories'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business, MenuItem $menuitem, $id)
    {
      $menuextracategory = MenuExtraCategory::find($id);
      if (request()->ajax()) {
        return view('menuextracategories.modal-form-menuextracategory')
          ->withAction('edit')
          ->withBusiness($business)
          ->withMenuitem($menuitem)
          ->withMenuextracategory($menuextracategory)
          ->withAjax(true)
          ->withTitle('Edit a Menu Extra Category');
      }

      return view('menuextracategories.edit')
        ->withAjax(false)
        ->withMenuextracategory($menuextracategory)
        ->withBusiness($business)
        ->withMenuitem($menuitem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Business $business, MenuItem $menuitem, MenuExtraCategory $menuextracategory, Request $request)
    {

      $request->validate([
        'name' => ['required', 'regex:/[A-Za-z0-9. -]/', 'max:100', new MenuExtraCategoryUnique($menuextracategory->id, $menuitem->id)],
       ]);

       $menuextracategory->update([
         'name' => ucfirst($request['name']),
         'required' => $request->required,
         'menu_item_id' => $menuitem->id,
       ]);

       if (request()->ajax()) {
        $business->load('menuitems');
        return view('menuextracategories.list-item')
          ->withCategory($menuextracategory)
          ->withBusiness($business)
          ->withMenuitem($menuitem);
      }

      // redirect
      flash()->success('Successfully edited ' . $menuextracategory->name . '!');
      return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextracategories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business, MenuItem $menuitem, Request $request, $id)
    {
      $menuextracategory = MenuExtraCategory::find($id);
      $menuextracategory->menuextras()->delete();
      $menuextracategory->delete();
      flash()->success('Successfully deleted the menu extra category!');
      return redirect(URL::to('businesses/'.  $business->id . '/menuitems/' . $menuitem->id . '/menuextracategories'));
    }
}
