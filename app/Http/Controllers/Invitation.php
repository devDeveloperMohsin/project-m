<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    const MODELS = ['workspace', 'project'];

    protected $fillable = [
        'email',      // Email of the invitee
        'model',      // Type of invitation (e.g., workspace, project)
        'model_id',   // ID of the associated workspace or project
        'token',      // Unique token for the invitation
        'expires',    // Expiration date of the invitation
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires' => 'datetime',
    ];
}
