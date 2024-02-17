<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    const MODELS = ['workspace', 'project'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires' => 'datetime',
    ];
}
