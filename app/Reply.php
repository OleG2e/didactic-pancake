<?php

namespace App;

use App\Events\ReplyCreated;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'post_id', 'owner_id', 'category_id', 'description',
    ];
    protected $with = ['owner', 'post', 'category'];

    public function owner()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}