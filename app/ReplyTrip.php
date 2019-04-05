<?php

namespace App;

use App\Events\ReplyTripCreated;
use Illuminate\Database\Eloquent\Model;

class ReplyTrip extends Model
{
    protected $fillable = [
        'trip_id', 'owner_id', 'description',
    ];
    protected $with = ['owner', 'trip'];

    protected $dispatchesEvents = [
        'created' => ReplyTripCreated::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
