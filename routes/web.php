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

Route::get('news', 'NewsController@index')->name('news_all');
Route::post('news', 'NewsController@store');
Route::get('news/create', 'NewsController@create')->name('news_create');
Route::get('news/{news}', 'NewsController@show')->name('news_show');
Route::delete('news/{news}', 'NewsController@destroy');
Route::patch('news/{news}', 'NewsController@update');
Route::get('news/{news}/edit', 'NewsController@edit')->name('news_edit');

Route::get('ad', 'AdController@index')->name('ad_all');
Route::post('ad', 'AdController@store');
Route::get('ad/create', 'AdController@create')->name('ad_create');
Route::get('ad/{ad}', 'AdController@show')->name('ad_show');
Route::delete('ad/{ad}', 'AdController@destroy');
Route::patch('ad/{ad}', 'AdController@update');
Route::get('ad/{ad}/edit', 'AdController@edit')->name('ad_edit');