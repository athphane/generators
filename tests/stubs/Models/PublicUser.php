<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Javaabu\Auth\User as Authenticatable;

class PublicUser extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the admin url attribute
     */
    public function getAdminUrlAttribute(): string
    {
        return route('admin.public-users.show', $this);
    }

    public function guardName(): string
    {
        return 'web_public_user';
    }

    #[\Override]
    public function passwordUpdateUrl(): string
    {
        return route('portal.password.new-password');
    }

    #[\Override]
    public function homeUrl(): string
    {
        return route('portal.home');
    }

    #[\Override]
    public function loginUrl(): string
    {
        return route('portal.login');
    }

    #[\Override]
    public function getRouteForPasswordReset(): string
    {
        return 'portal.password.reset';
    }

    #[\Override]
    public function getRouteForEmailVerification(): string
    {
        return 'portal.verification.verify';
    }

    #[\Override]
    public function inactiveNoticeUrl(): string
    {
        return route('portal.verification.notice');
    }

    /**
     * User visible scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeUserVisible($query)
    {
        // try public user
        $public_user = auth()->user() instanceof PublicUser ?
            auth()->user() :
            auth()->guard('web_public_user')->user();

        if ($public_user) {
            return $query->where($this->getTable().'.id', $public_user->id);
        }

        // then try admin
        $admin = auth()->user() instanceof User ?
            auth()->user() :
            auth()->guard('web_admin')->user();

        if ($admin) {
            if ($admin->can('viewAny', static::class)) {
                // can view all
                return $query;
            }
        }

        // can't view any
        return $query->where($this->getTable().'.id', -1);
    }
}
