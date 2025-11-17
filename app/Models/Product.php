<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'factory_id',
        'product_category_id',
        'name',
        'slug',
        'sku',
        'description',
        'attributes',
        'price',
        'price_type',
        'is_published_storefront',
        'is_published_marketplace',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'is_published_storefront' => 'bool',
        'is_published_marketplace' => 'bool',
    ];

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

