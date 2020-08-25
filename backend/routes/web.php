<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin protected routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@index')->name('admin_dashboard');
    Route::resource('company', 'admin\company\CompanyController');
    Route::resource('product', 'admin\product\ProductController');
    Route::resource('rto', 'admin\rto\RtoController');
    Route::resource('purchase', 'admin\purchase\PurchaseOrderController');
    Route::get('products', 'admin\purchase\PurchaseOrderController@getProduct');
});

// distributor protected routes
Route::group(['middleware' => ['auth', 'distributor'], 'prefix' => 'distributor'], function () {
    Route::get('/', 'HomeController@index')->name('distributor_dashboard');
});

// dealer protected routes
Route::group(['middleware' => ['auth', 'dealer'], 'prefix' => 'dealer'], function () {
    Route::get('/', 'HomeController@index')->name('dealer_dashboard');
});

// rto protected routes
Route::group(['middleware' => ['auth', 'rto'], 'prefix' => 'rto'], function () {
    Route::get('/', 'HomeController@index')->name('rto_dashboard');
});


// distributor protected routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('change-password', 'Auth\LoginController@changePassword');
    Route::post('update-password', 'Auth\LoginController@updatePassword');
    Route::resource('users', 'admin\user\UserManagementController');
});