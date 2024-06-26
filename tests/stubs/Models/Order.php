<?php

namespace App\Models;

use Javaabu\Helpers\AdminModel\AdminModel;
use Javaabu\Helpers\AdminModel\IsAdminModel;
use Javaabu\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Javaabu\Generators\Tests\TestSupport\Enums\OrderStatuses;

class Order extends Model implements AdminModel
{
    use IsAdminModel;
    use LogsActivity;
    use HasFactory;

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
        'order_no',
        'status',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'order_no',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'order_no' => 'string',
            'status' => OrderStatuses::class,
        ];
    }

    /**
     * Get the admin url attribute
     */
    public function getAdminUrlAttribute(): string
    {
        return route('admin.orders.show', $this);
    }

    /**
     * Get the name for the admin link
     *
     * @return string
     */
    public function getAdminLinkNameAttribute(): string
    {
        return $this->order_no;
    }

    /**
     * A order belongs to a category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A order belongs to a product
     */
    public function productSlug(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }
}
