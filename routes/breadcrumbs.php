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

// Home > Ad
Breadcrumbs::for('ad_all', function ($trail) {
    $trail->parent('home');
    $trail->push('Объявления', route('ad_all'));
});

// Home > Ad > Create
Breadcrumbs::for('ad_create', function ($trail) {
    $trail->parent('ad_all');
    $trail->push('Создать объявление', route('ad_create'));
});

// Home > Ad > Edit
Breadcrumbs::for('ad_edit', function ($trail, $ad) {
    $trail->parent('ad_all');
    $trail->push('Редактировать объявление', route('ad_edit', $ad->id));
});

// Home > Ad > Show
Breadcrumbs::for('ad_show', function ($trail, $ad) {
    $trail->parent('ad_all');
    $trail->push('Детали объявления', route('ad_show', $ad->id));
});

// Home > News
Breadcrumbs::for('news_all', function ($trail) {
    $trail->parent('main');
    $trail->push('Новости', route('news_all'));
});

// Home > News > Create
Breadcrumbs::for('news_create', function ($trail) {
    $trail->parent('news_all');
    $trail->push('Создать новость', route('news_create'));
});

// Home > News > Edit
Breadcrumbs::for('news_edit', function ($trail, $news) {
    $trail->parent('news_all');
    $trail->push('Редактировать новость', route('news_edit', $news->id));
});

// Home > News > Show
Breadcrumbs::for('news_show', function ($trail, $news) {
    $trail->parent('news_all');
    $trail->push('Детали новости', route('ad_show', $news->id));
});

// Home > How much
Breadcrumbs::for('how_much', function ($trail) {
    $trail->parent('main');
    $trail->push('Узнать сколько времени осталось', route('how_much'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});