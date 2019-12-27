<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontendPost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frontend_post_dataset';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
