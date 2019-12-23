<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOverallProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_overall_profile_dataset';

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'datetime',
    ];
}
