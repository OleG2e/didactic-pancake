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
Route::post('home', 'HomeController@store');
Route::resource('categories', 'CategoryController');
Route::resource('towns', 'TownController');

Route::get('posts', 'PostController@index')->name('post_all');
Route::post('posts', 'PostController@store');
Route::get('posts/create', 'PostController@create')->name('post_create');
Route::get('posts/{post}', 'PostController@show')->name('post_show');
Route::delete('posts/{post}', 'PostController@destroy');
Route::patch('posts/{post}', 'PostController@update');
Route::get('posts/{post}/edit', 'PostController@edit')->name('post_edit');

Route::post('replies', 'ReplyController@store');
Route::delete('replies/{reply}', 'ReplyController@destroy');
Route::patch('replies/{reply}', 'ReplyController@update');

Route::get('trips', 'TripController@index')->name('trip_all');
Route::post('trips', 'TripController@store');
Route::get('trips/create', 'TripController@create')->name('trip_create');
Route::get('trips/{trip}', 'TripController@show')->name('trip_show');
Route::delete('trips/{trip}', 'TripController@destroy');
Route::patch('trips/{trip}', 'TripController@update');
Route::get('trips/{trip}/edit', 'TripController@edit')->name('trip_edit');