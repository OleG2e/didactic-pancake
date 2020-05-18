<?php

namespace App;

use App\Interfaces\iReply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model implements iReply
{
    const MODEL_NAME = 'delivery';

    protected $fillable = [
        'category_id',
        'description',
        'endpoint_id',
        'owner_id',
//        'price',
        'relevance',
        'startpoint_id',
        'date_time',
    ];

    protected $with = ['category', 'owner', 'startpoint', 'endpoint'];
    protected $perPage = 12;

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
        return $this->hasMany(Reply::class, 'model_id')->where('model_name', self::MODEL_NAME)->paginate();
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
