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
});

Route::get('home', 'HomeController@index')->name('home');
Route::resource('categories', 'CategoryController');

Route::get('news', 'NewsController@index');
Route::post('news', 'NewsController@store');
Route::get('news/create', 'NewsController@create');
Route::get('news/{news}', 'NewsController@show');
Route::delete('news/{news}', 'NewsController@destroy');
Route::patch('news/{news}', 'NewsController@update');
Route::get('news/{news}/edit', 'NewsController@edit');

