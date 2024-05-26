<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskHistory extends Model
{
    use HasFactory;

    const TYPE_TASK_CREATED = 'Created Task';
    const TYPE_TASK_Updated = 'Updated Task';
    const TYPE_COMMENTED = 'Added Comment';
    const TYPE_DELETED_COMMENTED = 'Deleted Comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'type',
        'data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Interact with the user's first name.
     */
    protected function data(): Attribute
    {
        return Attribute::make(
            set: function ($value){
                // Ensure the value is an array (or decode if it's a JSON string)
                if (is_string($value)) {
                    $value = json_decode($value, true);
                }

                if (is_array($value)) {
                    $processedData = array_map(function ($item) {
                        // Strip HTML tags
                        $stripped = strip_tags($item);

                        // Limit characters to 50 and add ellipsis if needed
                        if (strlen($stripped) > 50) {
                            return substr($stripped, 0, 50) . '...';
                        }

                        return $stripped;
                    }, $value);

                    // Encode back to JSON
                    return json_encode($processedData);
                } else {
                    // If not an array, just set the original value
                    return $value;
                }
            }
        );
    }
}
