<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'message',
        'is_read',
    ];

    /**
     * Relationship: The group this message belongs to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function groupmessage()
    {
        return $this->belongsTo(GroupMessage::class);
    }

    /**
     * Relationship: The user who sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
