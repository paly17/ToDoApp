<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'ItemController@index')->name('home');

Route::resource('/item', 'ItemController');

Route::get('/item/delete/{index}', 'ItemController@delete')->name('item.delete');

Route::post('/home/filter', 'ItemController@filter')->name('home.filter');

Route::get('/home/previousPage/{easy}/{medium}/{hard}/{mine}/{shared}/{completed}/{not_completed}/{current_page}', 'ItemController@previousPage')->name('home.previousPage');

Route::get('/home/nextPage/{easy}/{medium}/{hard}/{mine}/{shared}/{completed}/{not_completed}/{current_page}', 'ItemController@nextPage')->name('home.nextPage');

//Route::get('/user', 'UserController@index');
