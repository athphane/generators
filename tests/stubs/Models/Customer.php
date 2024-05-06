<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Javaabu\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'designation',
        'address',
        'on_sale',
        'expire_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        $casts = parent::casts();

        return $casts + [
            'designation' => 'string',
            'address' => 'string',
            'on_sale' => 'boolean',
            'expire_at' => 'datetime',
        ];
    }

    /**
     * Convert dates to Carbon
     */
    public function setExpireAtAttribute($value)
    {
        return $this->attributes['expire_at'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Get the admin url attribute
     */
    public function getAdminUrlAttribute(): string
    {
        return route('admin.customers.show', $this);
    }

    public function guardName(): string
    {
        return 'web_customer';
    }

    #[\Override]
    public function passwordUpdateUrl(): string
    {
        return route('customer.password.new-password');
    }

    #[\Override]
    public function homeUrl(): string
    {
        return route('customer.home');
    }

    #[\Override]
    public function loginUrl(): string
    {
        return route('customer.login');
    }

    #[\Override]
    public function getRouteForPasswordReset(): string
    {
        return 'customer.password.reset';
    }

    #[\Override]
    public function getRouteForEmailVerification(): string
    {
        return 'customer.verification.verify';
    }

    #[\Override]
    public function inactiveNoticeUrl(): string
    {
        return route('customer.verification.notice');
    }

    /**
     * User visible scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeUserVisible($query)
    {
        // try customer
        $customer = auth()->user() instanceof Customer ?
            auth()->user() :
            auth()->guard('web_customer')->user();

        if ($customer) {
            return $query->where($this->getTable().'.id', $customer->id);
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

    /**
     * A customer belongs to a category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
