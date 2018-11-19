<?php

// INSPECTED ROUTES
Route::group(['middleware' => ['auth']], function() {
  Route::group(['middleware' => ['checkpermissions']], function() {

      // ADMIN
      Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

          // USERS
          Route::resource('user', 'UserController', ['as' => 'admin']);
              Route::get('user/{user}/toggle-role', 'UserController@toggleRole', ['as' => 'admin'])->name('admin.user.toggle-role');
              Route::get('user/{user}/set-business', 'UserController@setBusiness', ['as' => 'admin'])->name('admin.user.set-business');

          // ROLES
          Route::resource('role', 'RoleController', ['except' => ['destroy'], 'as' => 'admin']);
          Route::get('update-developer-permissions', 'RoleController@updateDeveloperPermissions')->name('admin.role.update-developer-permissions');

          // MODULES
          Route::resource('module', 'ModuleController', ['only' => ['index','store'], 'as' => 'admin']);
      });

      // ACCOUNT
      Route::resource('account', 'AccountController', ['only' => ['index','update','destroy']]);
          // Reviews by account
          Route::get('account/reviews', 'AccountController@reviews')->name('account.view-reviews');

      // BUSINESS
      Route::resource('businesses', 'BusinessController', ['except' => ['show']]);
          // Businesses' transactions
          Route::get('businesses/{business}/transactions', 'BusinessController@transactions')->name('businesses.transactions');
          Route::get('businesses/{business}/transactions/{transaction}', 'BusinessController@transaction')->name('businesses.transaction');


      // MENUS
      Route::resource('businesses/{business}/menus', 'MenuController', ['except' => ['show', 'index']]);

      // MENU ITEMS
      Route::resource('businesses/{business}/menuitems', 'MenuItemController', ['except' => ['show', 'index']]);

      // MENU EXTRAS
      Route::resource('businesses/{business}/menuitems/{menuitem}/menuextras', 'MenuExtraController');

      Route::resource('businesses/{business}/menuitems/{menuitem}/menuextracategories', 'MenuExtraCategoryController');

      // REVIEWS
      Route::resource('businesses/{business}/menuitems/{menuitem}/reviews', 'ReviewController', ['only' => ['store', 'create']]);

      // TRANSACTIONS
      Route::resource('transactions', 'TransactionController', ['only' => ['index', 'show']]);


  });
  Route::get('/setphone', function() {
    return view('users/addphone');
  });
  Route::post('/updatephone', 'AccountController@updatephone');
  Route::get('/updatephone/send', function () {
    return view('users.phonecheck');
  });
  Route::get('/subscribe', 'UserEmailController@subscribe');
  Route::get('/cartitems/destroy/{id}', 'CartItemController@destroy');
  Route::get('/cartitems/edit/{id}', 'CartItemController@edit');
  Route::get('/checknotifications', 'TransactionController@checknotifications');
  Route::get('/cartextras/add/{id}/{itemid}', 'CartExtraController@add');
  Route::get('/cartextras/destroy/{id}/{itemid}', 'CartExtraController@destroy');
  Route::get('/confirm/{businessid}', 'AccountController@confirm');

  Route::post('/updatephone/check', 'AccountController@checkphone')->name('updatephone.check');
  Route::post('/cartitems/add', 'CartItemController@add')->name('cartitems.add');
  Route::post('/cartitems/setcomments/{id}', 'CartItemController@setcomments');
  Route::post('/finish', 'TransactionController@store');
});
// UNINSPECTED ROUTES

Route::get('/confirmaccount/{token}', 'UserEmailController@authenticate');
Route::get('/unsubscribe/{value}', 'UserEmailController@unsubscribe');

// Reviews by Menu item
Route::get('businesses/{business}/menuitems/{menuitem}/reviews', 'MenuItemController@reviews')->name('menuitems.view-reviews');
Route::get('/', 'HomeController@main')->name('main');

Route::get('/partner', function () {
    return view('partner');
});
Route::get('/help', function () {
    return view('help');
});
Route::get('/tos', function () {
    return view('tos');
});

Route::get('/business-tos', function () {
    return view('business_tos');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/requestbusiness', function () {
    return view('requestbusiness');
});

Route::get('/business-guide', function() {
    return view('business_guide');
});

Route::get('/business-evidence', function() {
    return view('business_evidence');
});

Route::get('/business-about', function() {
    return view('about_business');
});

Route::get('/contact', 'ContactController@view');

Route::post('/contact/send', 'ContactController@send');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('businesses', 'BusinessController', ['only' => ['show']]);
Route::resource('businesses/{business}/menuitems', 'MenuItemController', ['only' => ['show']]);
Route::resource('businesses/{business}/menus', 'MenuController', ['only' => ['show']]);

Auth::routes();

Route::get('register-business', 'Auth\BusinessRegisterController@showRegistrationForm')->name('register-business');
Route::post('register-business', 'Auth\BusinessRegisterController@register');

Route::get('file-upload', 'FileController@fileUpload');
Route::post('file-upload', 'FileController@fileUploadPost')->name('fileUploadPost');


Route::get('/search', 'BusinessController@index')->name('businesses.search');
Route::get('/tags/{tag}', 'BusinessController@tags')->name('businesses.tags');

Route::post('/getaddresscoords', 'HomeController@getaddresscoords');
