<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
