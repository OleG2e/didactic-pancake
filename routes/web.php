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

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('how-much', function () {
    return view('how_much');
})->name('how_much');

Route::get('home', 'HomeController@index')->name('home');
Route::resource('categories', 'CategoryController');

Route::get('post', 'PostController@index')->name('post_all');
Route::post('post', 'PostController@store');
Route::get('post/create', 'PostController@create')->name('post_create');
Route::get('post/{post}', 'PostController@show')->name('post_show');
Route::delete('post/{post}', 'PostController@destroy');
Route::patch('post/{post}', 'PostController@update');
Route::get('post/{post}/edit', 'PostController@edit')->name('post_edit');

Route::post('reply', 'ReplyController@store');

Route::get('trip', 'TripController@index')->name('trip_all');
Route::post('trip', 'TripController@store');
Route::get('trip/create', 'TripController@create')->name('trip_create');
Route::get('trip/{trip}', 'TripController@show')->name('trip_show');
Route::delete('trip/{trip}', 'TripController@destroy');
Route::patch('trip/{trip}', 'TripController@update');
Route::get('trip/{trip}/edit', 'TripController@edit')->name('trip_edit');