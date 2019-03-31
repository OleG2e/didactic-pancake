<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'category_id', 'owner_id', 'date_time', 'description', 'load', 'relevance', 'startpoint_id', 'endpoint_id', 'passengers_count',
    ];

    protected $with = ['category', 'owner', 'startpoint', 'endpoint', 'users'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'post_id');
    }

    public function startpoint()
    {
        return $this->belongsTo(Town::class, 'startpoint_id');
    }

    public function endpoint()
    {
        return $this->belongsTo(Town::class, 'endpoint_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
