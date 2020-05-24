<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::view('/bus-schedule', 'entries.bus-schedule')->name('bus.schedule');

Route::group(
    ['prefix' => 'admin', 'middleware' => 'admin'],
    function () {
        Route::get('mail', 'AdminController@feedbackForm')->name('admin.feedback.form');
        Route::post('mail', 'AdminController@feedbackSubmit')->name('admin.feedback.submit');
    }
);

Route::get('/', 'WelcomeController@index')->name('main');
Route::group(
    ['prefix' => 'home'],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('/', 'HomeController@store')->name('home.store');
        Route::get('/posts', 'HomeController@myPosts')->name('my.posts');
        Route::get('/trips', 'HomeController@myTrips')->name('my.trips');
        Route::get('/replies', 'HomeController@myReplies')->name('my.replies');
        Route::get('/deliveries', 'HomeController@myDeliveries')->name('my.deliveries');
        Route::get('/feedback', 'HomeController@feedbackForm')->name('feedback.form');
        Route::post('/feedback', 'HomeController@feedbackSubmit')->name('feedback.submit');
        Route::patch('/posts/{post}', 'HomeController@updateRelevancePost')->name('update.relevance.post');
        Route::patch('/trips/{trip}', 'HomeController@updateRelevanceTrip')->name('update.relevance.trip');
        Route::patch('/deliveries/{trip}', 'HomeController@updateRelevanceDelivery')->name('update.relevance.delivery');
        Route::post('/image/upload', 'HomeController@updateAvatar')->name('home.image.upload');
    }
);

Route::group(
    ['prefix' => 'posts', 'as' => 'post.'],
    function () {
        Route::post('/', 'PostController@store')->name('store');
        Route::get('/create', 'PostController@create')->name('create');
        Route::get('/{category}', 'PostController@index')->name('all');
        Route::get('/{category}/{post}', 'PostController@show')->name('show');
        Route::delete('/{category}/{post}', 'PostController@destroy')->name('destroy');
        Route::patch('/{category}/{post}', 'PostController@update')->name('update');
        Route::get('/{category}/{post}/edit', 'PostController@edit')->name('edit');
        Route::post('/{category}/{post}/link', 'PostController@linkRequest')->name('link.request');
    }
);

Route::group(
    ['prefix' => 'replies/{model_name}/{model_id}', 'middleware' => ['auth', 'verified'], 'as' => 'reply.'],
    function () {
        Route::post('/', 'ReplyController@store')->name('store');
        Route::delete('/{reply}', 'ReplyController@destroy')->name('destroy');
        Route::patch('/{reply}', 'ReplyController@update')->name('update');
        Route::get('/{reply}/edit', 'ReplyController@edit')->name('edit');
        Route::post('/{reply}/link', 'ReplyController@linkRequest')->name('link.request');
    }
);

Route::group(
    ['prefix' => 'trips', 'as' => 'trip.'],
    function () {
        Route::get('/', 'TripController@index')->name('all');
        Route::post('/', 'TripController@store')->name('store');
        Route::get('/create', 'TripController@create')->name('create');
        Route::get('/{trip}', 'TripController@show')->name('show');
        Route::delete('/{trip}', 'TripController@destroy')->name('destroy');
        Route::patch('/{trip}', 'TripController@update')->name('update');
        Route::get('/{trip}/edit', 'TripController@edit')->name('edit');

        Route::patch('/{trip}/addUser', 'TripUserController@addUser')->name('add.user');
        Route::delete('/{trip}/removeUser', 'TripUserController@removeUser')->name('remove.user');
    }
);

Route::group(
    ['prefix' => 'deliveries', 'as' => 'delivery.'],
    function () {
        Route::get('/', 'DeliveryController@index')->name('all');
        Route::post('/', 'DeliveryController@store')->name('store');
        Route::get('/create', 'DeliveryController@create')->name('create');
        Route::get('/{delivery}', 'DeliveryController@show')->name('show');
        Route::delete('/{delivery}', 'DeliveryController@destroy')->name('destroy');
        Route::patch('/{delivery}', 'DeliveryController@update')->name('update');
        Route::get('/{delivery}/edit', 'DeliveryController@edit')->name('edit');
        Route::post('/{delivery}/link', 'DeliveryController@linkRequest')->name('link.request');
    }
);