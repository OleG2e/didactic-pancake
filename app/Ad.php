<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function category()
    {
        $this->belongsTo(Category::class, 'category_id');
    }
}
