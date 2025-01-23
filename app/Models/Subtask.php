<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'title',
        'status',
        'description',
        'type',
        'priority',
        'sorting',
        'due_date',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }
}
