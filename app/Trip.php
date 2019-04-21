<?php

namespace App;

use App\Events\TripCreated;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'category_id', 'owner_id', 'date_time', 'description', 'load', 'relevance', 'startpoint_id', 'endpoint_id',
        'passengers_count', 'price',
    ];

    protected $with = ['category', 'owner', 'startpoint', 'endpoint', 'users'];

    protected $dispatchesEvents = [
        'created' => TripCreated::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function replies()
    {
        return $this->hasMany(ReplyTrip::class);
    }

    public function startpoint()
    {
        return $this->belongsTo(Town::class, 'startpoint_id')->withDefault();
    }

    public function endpoint()
    {
        return $this->belongsTo(Town::class, 'endpoint_id')->withDefault();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
