<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id', 'owner_id', 'title', 'description', 'relevance', 'images',
    ];

    protected $with = ['category', 'owner'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function replies()
    {
        return $this->hasMany(ReplyPost::class);
    }
}
