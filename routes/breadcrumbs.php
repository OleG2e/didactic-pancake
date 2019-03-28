<?php
/**
 * Created by PhpStorm.
 * User: olegbiruk
 * Date: 2019-01-15
 * Time: 13:53
 */
// Home
Breadcrumbs::for('main', function ($trail) {
    $trail->push('Главная', route('main'));
});

// Home > About
Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Home > Cabinet
Breadcrumbs::for('home', function ($trail) {
    $trail->parent('main');
    $trail->push('Кабинет', route('home'));
});

// Home > Post
Breadcrumbs::for('post_all', function ($trail) {
    $trail->parent('main');
    $trail->push('Объявления', route('post_all'));
});

// Home > Post > Create
Breadcrumbs::for('post_create', function ($trail) {
    $trail->parent('post_all');
    $trail->push('Создать объявление', route('post_create'));
});

// Home > Post > Edit
Breadcrumbs::for('post_edit', function ($trail, $post) {
    $trail->parent('post_all');
    $trail->push('Редактировать объявление', route('post_edit', $post->id));
});

// Home > Post > Show
Breadcrumbs::for('post_show', function ($trail, $post) {
    $trail->parent('post_all');
    $trail->push('Детали объявления', route('post_show', $post->id));
});

// Home > Trip
Breadcrumbs::for('trip_all', function ($trail) {
    $trail->parent('main');
    $trail->push('Поездки', route('trip_all'));
});

// Home > Trip > Create
Breadcrumbs::for('trip_create', function ($trail) {
    $trail->parent('trip_all');
    $trail->push('Создать объявление', route('trip_create'));
});

// Home > Trip > Edit
Breadcrumbs::for('trip_edit', function ($trail, $trip) {
    $trail->parent('trip_all');
    $trail->push('Редактировать объявление', route('trip_edit', $trip->id));
});

// Home > Trip > Show
Breadcrumbs::for('trip_show', function ($trail, $trip) {
    $trail->parent('trip_all');
    $trail->push('Детали объявления', route('trip_show', $trip->id));
});

// Home > How much
Breadcrumbs::for('how_much', function ($trail) {
    $trail->parent('main');
    $trail->push('Узнать сколько времени осталось', route('how_much'));
});

//// Home > Blog > [Category]
//Breadcrumbs::for('category', function ($trail, $category) {
//    $trail->parent('blog');
//    $trail->push($category->title, route('category', $category->id));
//});
//
//// Home > Blog > [Category] > [Post]
//Breadcrumbs::for('post', function ($trail, $post) {
//    $trail->parent('category', $post->category);
//    $trail->push($post->title, route('post', $post->id));
//});