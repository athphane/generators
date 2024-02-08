<?php

namespace App\Models;

use Javaabu\Helpers\AdminModel\AdminModel;
use Javaabu\Helpers\AdminModel\IsAdminModel;
use Javaabu\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model implements AdminModel
{
    use HasFactory;
    use IsAdminModel;
    use LogsActivity;
    use SoftDeletes;

    /**
     * The attributes that would be logged
     *
     * @var array
     */
    protected static array $logAttributes = ['*'];

    /**
     * Changes to these attributes only will not trigger a log
     *
     * @var array
     */
    protected static array $ignoreChangedAttributes = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'slug',
        'description',
        'price',
        'stock',
        'on_sale',
        'features',
        'published_at',
        'expire_at',
        'released_on',
        'sale_time',
        'status',
        'manufactured_year',
    ];

    /**
     * The attributes that are cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'on_sale' => 'boolean',
        'features' => 'array',
        'published_at' => 'datetime',
        'expire_at' => 'datetime',
        'released_on' => 'date',
        'sale_time' => 'datetime',
        'manufactured_year' => 'integer',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'name',
        'address',
        'slug',
    ];

    /**
     * Convert dates to Carbon
     */
    public function setPublishedAtAttribute($value)
    {
        return $this->attributes['published_at'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Convert dates to Carbon
     */
    public function setExpireAtAttribute($value)
    {
        return $this->attributes['expire_at'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Convert dates to Carbon
     */
    public function setReleasedOnAttribute($value)
    {
        return $this->attributes['released_on'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Convert dates to Carbon
     */
    public function setSaleTimeAttribute($value)
    {
        return $this->attributes['sale_time'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Get the admin url attribute
     */
    public function getAdminUrlAttribute(): string
    {
        return route('admin.products.show', $this);
    }

    /**
     * A product belongs to a category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
