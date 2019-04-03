<?php

namespace App;

use App\Events\ReplyCreated;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'post_id', 'owner_id', 'description',
    ];
    protected $with = ['owner', 'post'];

    protected $dispatchesEvents = [
        'created' => ReplyCreated::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
