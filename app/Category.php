<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['title', 'slug'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
