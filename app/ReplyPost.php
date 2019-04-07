<?php

namespace App;

use App\Events\ReplyPostCreated;
use Illuminate\Database\Eloquent\Model;

class ReplyPost extends Model
{
    protected $fillable = [
        'post_id', 'owner_id', 'description',
    ];
    protected $with = ['owner', 'post'];

    protected $dispatchesEvents = [
        'created' => ReplyPostCreated::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function post()
    {
        return $this->belongsTo(Post::class)->withDefault();
    }
}