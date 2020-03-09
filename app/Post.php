<?php

namespace App;

use App\Interfaces\iReply;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements iReply
{
    const MODEL_NAME = 'post';

    protected $fillable = [
        'category_id',
        'description',
        'images',
        'owner_id',
        'relevance',
        'title',
    ];

    protected $with = ['category', 'owner'];

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
}
