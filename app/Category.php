<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
