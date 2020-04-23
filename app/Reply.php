<?php

namespace App;

use App\Events\ReplyCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    public static object $model;
    public static string $modelName;

    protected $fillable = [
        'attachment',
        'description',
        'model_id',
        'model_name',
        'owner_id',
    ];
    protected $with = ['owner'];
    protected $touches = ['trip', 'post', 'delivery'];
    protected $perPage = 30;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'model_id')->withDefault();
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'model_id')->withDefault();
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'model_id')->withDefault();
    }

    public function parent(string $model_name): object
    {
        switch ($model_name) {
            case Trip::MODEL_NAME:
                return $this->trip;
                break;
            case Delivery::MODEL_NAME:
                return $this->delivery;
                break;
            default:
                return $this->post;
        }
    }

    public static function getCurrentParentModel(string $model_name, int $model_id): object
    {
        switch ($model_name) {
            case Trip::MODEL_NAME:
                return Trip::findOrFail($model_id);
                break;
            case Delivery::MODEL_NAME:
                return Delivery::findOrFail($model_id);
                break;
            default:
                return Post::findOrFail($model_id);
        }
    }
}