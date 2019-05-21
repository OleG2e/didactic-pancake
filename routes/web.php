<?php

Auth::routes(['verify' => true]);

Route::get('/bus-schedule', function () {
    return view('entries.bus-schedule');
})->name('bus.schedule');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/mail', 'AdminController@feedbackForm')->name('admin.feedback.form');
    Route::post('/admin/mail', 'AdminController@feedbackSubmit')->name('admin.feedback.submit');
});

Route::get('/', 'WelcomeController@index')->name('main');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@store')->name('home.store');
Route::get('/home/posts', 'HomeController@myPosts')->name('my.posts');
Route::get('/home/trips', 'HomeController@myTrips')->name('my.trips');
Route::get('/home/deliveries', 'HomeController@myDeliveries')->name('my.deliveries');
Route::get('/home/feedback', 'HomeController@feedbackForm')->name('feedback.form');
Route::post('/home/feedback', 'HomeController@feedbackSubmit')->name('feedback.submit');
Route::patch('/home/posts/{post}', 'HomeController@updateRelevancePost')->name('update.relevance.post');
Route::patch('/home/trips/{trip}', 'HomeController@updateRelevanceTrip')->name('update.relevance.trip');
Route::patch('/home/deliveries/{trip}', 'HomeController@updateRelevanceDelivery')->name('update.relevance.delivery');
Route::post('/home/image/upload', 'HomeController@updateAvatar')->name('home.image.upload');

Route::post('/posts', 'PostController@store')->name('post.store');
Route::get('/posts/create', 'PostController@create')->name('post.create');
Route::get('/posts/buy', 'PostController@index')->name('post.buy');
Route::get('/posts/sell', 'PostController@index')->name('post.sell');
Route::get('/posts/help', 'PostController@index')->name('post.help');
Route::get('/posts/pets', 'PostController@index')->name('post.pet');
Route::get('/posts/service', 'PostController@index')->name('post.service');
Route::get('/posts/loss', 'PostController@index')->name('post.loss');
Route::get('/posts/{post}', 'PostController@show')->name('post.show');
Route::delete('/posts/{post}', 'PostController@destroy')->name('post.destroy');
Route::patch('/posts/{post}', 'PostController@update')->name('post.update');
Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');
Route::post('/posts/{post}/link', 'PostController@linkRequest')->name('post.link.request');

Route::post('/replies', 'ReplyController@store')->name('reply.store');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('reply.destroy');
Route::patch('/replies/{reply}', 'ReplyController@update')->name('reply.update');
Route::get('/replies/{reply}/edit', 'ReplyController@edit')->name('reply.edit');
Route::post('/replies/{reply}/link', 'ReplyController@linkRequest')->name('reply.link.request');

Route::get('/trips', 'TripController@index')->name('trip.all');
Route::post('/trips', 'TripController@store')->name('trip.store');
Route::get('/trips/create', 'TripController@create')->name('trip.create');
Route::get('/trips/{trip}', 'TripController@show')->name('trip.show');
Route::delete('/trips/{trip}', 'TripController@destroy')->name('trip.destroy');
Route::patch('/trips/{trip}', 'TripController@update')->name('trip.update');
Route::get('/trips/{trip}/edit', 'TripController@edit')->name('trip.edit');

Route::get('/deliveries', 'DeliveryController@index')->name('delivery.all');
Route::post('/deliveries', 'DeliveryController@store')->name('delivery.store');
Route::get('/deliveries/create', 'DeliveryController@create')->name('delivery.create');
Route::get('/deliveries/{trip}', 'DeliveryController@show')->name('delivery.show');
Route::delete('/deliveries/{trip}', 'DeliveryController@destroy')->name('delivery.destroy');
Route::patch('/deliveries/{trip}', 'DeliveryController@update')->name('delivery.update');
Route::get('/deliveries/{trip}/edit', 'DeliveryController@edit')->name('delivery.edit');
Route::post('/deliveries/{trip}/link', 'DeliveryController@linkRequest')->name('delivery.link.request');

Route::patch('/trips/{trip}/addUser', 'TripUserController@addUser')->name('add.user');
Route::delete('/trips/{trip}/removeUser', 'TripUserController@removeUser')->name('remove.user');