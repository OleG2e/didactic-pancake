<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    protected $fillable = ['latitude', 'longitude'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->withDefault();
    }
}
