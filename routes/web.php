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
/*Login*/
Route::name('admin.')->middleware('isLogin')->group(function(){
  Route::get('/login','Back\AdminController@login')->name('login');
  Route::post('/login','Back\AdminController@loginPost')->name('login.post');
});

Route::name('admin.')->middleware('isAdmin')->group(function(){
  /*Logout*/
  Route::get('/logout','Back\AdminController@logout')->name('logout');

  /*Home Page*/
  Route::get('/','Back\AdminController@index')->name('dashboard');
  Route::get('/homepage','Back\AdminController@index')->name('dashboard');

  /*Data Panel*/
  Route::get('/datapanel','Back\AdminController@dataPanel')->name('datapanel');
  Route::get('/switch','Back\AdminController@switch')->name('switch');
  Route::get('/fetch','Back\AdminController@fetch')->name('ajax.data');
  Route::post('/datapanel/insert','Back\AdminController@insert')->name('ajax.insert');
  Route::post('/datapanel/update','Back\AdminController@update')->name('ajax.update');
  Route::get('/datapanel/delete','Back\AdminController@delete')->name('ajax.delete');

  //Cancled
  Route::get('/canceled','Back\AdminController@cancelPanel')->name('cancelpanel');
  Route::get('/cancel','Back\AdminController@trash')->name('ajax.cancel');
  Route::get('/recover','Back\AdminController@recover')->name('recover');
  Route::get('/destroy','Back\AdminController@destroy')->name('destroy');

  /*Customer*/
  Route::get('/customer','Back\CustomerController@index')->name('customer');
  Route::post('/customer/insert','Back\CustomerController@insert')->name('customer.insert');
  Route::post('/customer/update','Back\CustomerController@update')->name('customer.update');
  Route::get('/customer/delete','Back\CustomerController@delete')->name('customer.delete');
  Route::post('/customer/nameupdate','Back\CustomerController@nameupdate')->name('customer.nameupdate');

  /*Ip List*/
  Route::get('/iplist','Back\IpListController@index')->name('iplist');
  Route::post('/iplist/insert','Back\IpListController@insert')->name('iplist.insert');
  Route::post('/iplist/update','Back\IpListController@update')->name('iplist.update');
  Route::get('/iplist/delete','Back\IpListController@delete')->name('iplist.delete');
  Route::get('/iplist/switch','Back\IpListController@switch')->name('iplist.switch');

  /*Calculator*/
  Route::get('/calculator','Back\AdminController@calculator')->name('calculator');
});
