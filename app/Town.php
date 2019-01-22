<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = ['title'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
