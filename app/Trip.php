<?php

namespace App;

use App\Interfaces\iReply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model implements iReply
{
    const MODEL_NAME = 'trip';

    protected $fillable = [
        'category_id',
        'date_time',
        'description',
        'endpoint_id',
        'load',
        'owner_id',
        'passengers_count',
        'price',
        'relevance',
        'startpoint_id',
    ];

    protected $with = ['category', 'owner', 'startpoint', 'endpoint', 'users'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->withDefault();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function replies(): LengthAwarePaginator
    {
        return $this->hasMany(Reply::class, 'model_id')->paginate(10);
    }

    public function startpoint(): BelongsTo
    {
        return $this->belongsTo(Town::class, 'startpoint_id')->withDefault();
    }

    public function endpoint(): BelongsTo
    {
        return $this->belongsTo(Town::class, 'endpoint_id')->withDefault();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
