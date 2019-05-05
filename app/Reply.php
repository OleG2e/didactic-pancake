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

    protected $dispatchesEvents = [
        'created' => ReplyCreated::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function post()
    {
        return $this->belongsTo(Post::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}