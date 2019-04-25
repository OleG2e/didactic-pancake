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

// Home > admin
Breadcrumbs::for('admin.feedback.form', function ($trail) {
    $trail->parent('main');
    $trail->push('Написать юзеру', route('admin.feedback.form'));
});

// Home > About
Breadcrumbs::for('feedback.form', function ($trail) {
    $trail->parent('home');
    $trail->push('Написать админу', route('feedback.form'));
});

// Home > Cabinet
Breadcrumbs::for('home', function ($trail) {
    $trail->parent('main');
    $trail->push('Кабинет', route('home'));
});

// Home > Post
Breadcrumbs::for('post.all', function ($trail) {
    $trail->parent('main');
    $trail->push('Объявления', route('post.all'));
});

// Home > Post > Create
Breadcrumbs::for('post.create', function ($trail) {
    $trail->parent('post.all');
    $trail->push('Создать объявление', route('post.create'));
});

// Home > Post > Edit
Breadcrumbs::for('post.edit', function ($trail, $post) {
    $trail->parent('post.all');
    $trail->push('Редактировать объявление', route('post.edit', $post));
});

// Home > Post > Show
Breadcrumbs::for('post.show', function ($trail, $post) {
    $trail->parent('post.all');
    $trail->push('Детали объявления', route('post.show', $post));
});

// Home > Trip
Breadcrumbs::for('trip.all', function ($trail) {
    $trail->parent('main');
    $trail->push('Поездки', route('trip.all'));
});

// Home > Trip > Create
Breadcrumbs::for('trip.create', function ($trail) {
    $trail->parent('trip.all');
    $trail->push('Создать объявление', route('trip.create'));
});

// Home > Trip > Edit
Breadcrumbs::for('trip.edit', function ($trail, $trip) {
    $trail->parent('trip.all');
    $trail->push('Редактировать объявление', route('trip.edit', $trip));
});

// Home > Trip > Show
Breadcrumbs::for('trip.show', function ($trail, $trip) {
    $trail->parent('trip.all');
    $trail->push('Детали объявления', route('trip.show', $trip));
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