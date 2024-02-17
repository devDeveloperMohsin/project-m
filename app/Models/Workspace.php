<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Workspace extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // Workspace Roles
    const ROLE_ADMIN = 'workspace_admin';
    const ROLE_MEMBER = 'workspace_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function projects() {
        return $this->hasMany(Project::class, 'workspace_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('icon')
            ->fit(Fit::Crop, 400, 400)
            ->nonQueued();

        $this
            ->addMediaConversion('cover')
            ->fit(Fit::Crop, 2000, 416)
            ->nonQueued();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_users', 'workspace_id', 'user_id')->withPivot('role')->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'workspace_users', 'workspace_id', 'user_id')->withPivot('role')->wherePivot('role', self::ROLE_ADMIN)->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'workspace_users', 'workspace_id', 'user_id')->withPivot('role')->wherePivot('role', self::ROLE_MEMBER)->withTimestamps();
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
        return $this->hasMany(Invitation::class, 'model_id', 'id')->where('model', 'workspace');
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
}
