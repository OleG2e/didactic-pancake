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

// Home > Bus
Breadcrumbs::for('bus.schedule', function ($trail) {
    $trail->parent('main');
    $trail->push('Расписание движения автобусов', route('bus.schedule'));
});

// Home > Delivery
Breadcrumbs::for('delivery.all', function ($trail) {
    $trail->parent('main');
    $trail->push('Передачки', route('delivery.all'));
});

// Home > Delivery > Create
Breadcrumbs::for('delivery.create', function ($trail) {
    $trail->parent('delivery.all');
    $trail->push('Создать передачку', route('delivery.create'));
});

// Home > Delivery > Edit
Breadcrumbs::for('delivery.edit', function ($trail, $trip) {
    $trail->parent('delivery.all');
    $trail->push('Редактировать передачку', route('delivery.edit', $trip));
});

// Home > Delivery > Show
Breadcrumbs::for('delivery.show', function ($trail, $trip) {
    $trail->parent('delivery.all');
    $trail->push('Детали передачки', route('delivery.show', $trip));
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
    $trail->push('Объявления', route('post.all', 'all'));
});

// Home > Post > Category
Breadcrumbs::for('post.category', function ($trail, $category) {
    $trail->parent('post.all');
    $trail->push($category->title, route('post.all', $category->slug));
});

// Home > Post > Create
Breadcrumbs::for('post.create', function ($trail) {
    $trail->parent('main');
    $trail->push('Создать объявление', route('post.create'));
});

// Home > Post > Edit
Breadcrumbs::for('post.edit', function ($trail, $category, $post) {
    $trail->parent('main');
    $trail->push('Редактировать объявление', route('post.edit', [$category, $post]));
});

// Home > Post > Show
Breadcrumbs::for('post.show', function ($trail, $category, $post) {
    $trail->parent('post.category', $category);
    $trail->push('Детали объявления', route('post.show', [$category, $post]));
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