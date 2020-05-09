<?php

namespace App;

use App\Interfaces\iReply;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model implements iReply
{
    const MODEL_NAME = 'post';

    protected $fillable = [
        'category_id',
        'description',
        'images',
        'owner_id',
        'point_id',
        'relevance',
        'title',
    ];

    protected $with = ['category', 'owner', 'point'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->withDefault();
    }

    public function point(): BelongsTo
    {
        return $this->belongsTo(Point::class)->withDefault();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function replies(): LengthAwarePaginator
    {
        return $this->hasMany(Reply::class, 'model_id')->where('model_name', self::MODEL_NAME)->paginate(10);
    }

    public function countImages(): int
    {
        $images = json_decode($this->images);
        if (empty($images)) {
            return false;
        }
        return count($images->full);
    }
}
