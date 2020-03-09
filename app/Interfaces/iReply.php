<?php

namespace App\Interfaces;

use \Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface iReply
{
    /**
     * Get paginated replies for current model, for example App\Post.
     *
     * @return LengthAwarePaginator
     */
    public function replies(): LengthAwarePaginator;
}