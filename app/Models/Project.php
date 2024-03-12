<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Project Roles
    const ROLE_ADMIN = 'project_admin';
    const ROLE_MEMBER = 'project_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'workspace_id',
    ];

    public function workspacce()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')->withPivot('role')->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')->withPivot('role')->wherePivot('role', self::ROLE_ADMIN)->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')->withPivot('role')->wherePivot('role', self::ROLE_MEMBER)->withTimestamps();
    }

    public function userIsMember($userId)
    {
        return $this->users()->where('users.id', $userId)->wherePivot('role', '=', self::ROLE_MEMBER)->exists();
    }

    public function userIsAdmin($userId)
    {
        return $this->users()->where('users.id', $userId)->wherePivot('role', '=', self::ROLE_ADMIN)->exists();
    }

    public function invites()
    {
        return $this->hasMany(Invitation::class, 'model_id', 'id')->where('model', 'project');
    }

    public function roleMapping($role)
    {
        switch ($role) {
            case self::ROLE_ADMIN:
                return 'Admin';
                break;
            case self::ROLE_MEMBER:
                return 'Member';
                break;
            default:
                return '';
                break;
        }
    }

    public function boards()
    {
        return $this->hasMany(Board::class, 'project_id')->where('closed', 0)->orderBy('sorting')->latest();
    }
}
