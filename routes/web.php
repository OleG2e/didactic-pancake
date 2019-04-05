<?php

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/how-much', function () {
    return view('how_much');
})->name('how_much');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@store')->name('home.store');
Route::get('/home/posts', 'HomeController@myPosts')->name('my.posts');
Route::get('/home/entries', 'HomeController@myEntries')->name('my.entries');
Route::get('/home/trips', 'HomeController@myTrips')->name('my.trips');
Route::patch('/home/posts/{post}', 'HomeController@updateRelevancePost')->name('update.relevance.post');
Route::patch('/home/trips/{trip}', 'HomeController@updateRelevanceTrip')->name('update.relevance.trip');
Route::patch('/home/entries/{entry}', 'HomeController@updateRelevanceEntry')->name('update.relevance.entry');
Route::post('/home/image/upload', 'HomeController@updateAvatar')->name('image.upload');

Route::resource('categories', 'CategoryController');
Route::resource('towns', 'TownController');

Route::get('/posts', 'PostController@index')->name('post.all');
Route::post('/posts', 'PostController@store')->name('post.store');
Route::get('/posts/create', 'PostController@create')->name('post.create');
Route::get('/posts/{post}', 'PostController@show')->name('post.show');
Route::delete('/posts/{post}', 'PostController@destroy')->name('post.destroy');
Route::patch('/posts/{post}', 'PostController@update')->name('post.update');
Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');

Route::post('/replies-post', 'ReplyPostController@store')->name('reply.post.store');
Route::delete('/replies-post/{reply}', 'ReplyPostController@destroy')->name('reply.post.destroy');
Route::patch('/replies-post/{reply}', 'ReplyPostController@update')->name('reply.post.update');
Route::get('/replies-post/{reply}/edit', 'ReplyPostController@edit')->name('reply.post.edit');

Route::post('/replies-trip', 'ReplyTripController@store')->name('reply.trip.store');
Route::delete('/replies-trip/{reply}', 'ReplyTripController@destroy')->name('reply.trip.destroy');
Route::patch('/replies-trip/{reply}', 'ReplyTripController@update')->name('reply.trip.update');
Route::get('/replies-trip/{reply}/edit', 'ReplyTripController@edit')->name('reply.trip.edit');

Route::get('/trips', 'TripController@index')->name('trip.all');
Route::post('/trips', 'TripController@store')->name('trip.store');
Route::get('/trips/create', 'TripController@create')->name('trip.create');
Route::get('/trips/{trip}', 'TripController@show')->name('trip.show');
Route::delete('/trips/{trip}', 'TripController@destroy')->name('trip.destroy');
Route::patch('/trips/{trip}', 'TripController@update')->name('trip.update');
Route::get('/trips/{trip}/edit', 'TripController@edit')->name('trip.edit');

Route::patch('/trips/{trip}/addUser', 'TripUserController@addUser')->name('add.user');
Route::delete('/trips/{trip}/removeUser', 'TripUserController@removeUser')->name('remove.user');