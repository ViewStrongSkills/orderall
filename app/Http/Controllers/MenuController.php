<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business;
use App\Menu;
use Auth;
use URL;
use App\Http\Requests\StoreMenu;
use App\Http\Requests\UpdateMenu;


class MenuController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Business $business)
    {
        if (request()->ajax()) {
            return view('menus.modal-form-menu')
                ->withAction('create')
                ->withBusiness($business)
                ->withTitle('Create new Menu');
        }
        else {
          return view('menus.create')->withBusiness($business);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenu $request, Business $business)
    {

        if (!$request->ajax())
            return;

        $attributes = $request->all();
        $attributes['business_id'] = $business->id;

        $business->menus()->save(Menu::create($attributes));
        $business->load('menuswithitems');

        return view('businesses.menu')
            ->withUserTransactionItems(Auth::user()->transaction_items->pluck('menu_item_id'))
            ->withBusiness($business);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business, Menu $menu)
    {
      return view('menus.form-show')->withMenu($menu)->withTitle('View ' . $menu->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business, Menu $menu)
    {
        if (!request()->ajax())
            return view('menus.edit')
            ->withMenu($menu)
            ->withBusiness($business);

        $business->load('menus');

        return view('menus.modal-form-menu')
            ->withMenu($menu)
            ->withAction('edit')
            ->withBusiness($business)
            ->withTitle('Change Menu '. $menu->name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenu $request, Business $business, Menu $menu)
    {
        if (!request()->ajax())
            return;

        $menu->update($request->all());
        $business->load('menuswithitems');

        return view('businesses.menu')
            ->withUserTransactionItems(Auth::user()->transaction_items->pluck('menu_item_id'))
            ->withBusiness($business);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business, Menu $menu)
    {
      $menu->delete();

      flash()->success('Successfully deleted the menu!');
      return redirect(URL::to('businesses/' . $business->id));

    }
}
