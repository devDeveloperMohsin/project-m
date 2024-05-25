<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'board_id',
        'title',
        'description',
        'status',
        'priority',
        'type',
        'due_date',
        'sorting',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id');
    }
}
