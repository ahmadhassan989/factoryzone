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
        'status',
        'base_price',
        'currency',
        'unit',
        'is_published',
        'price',
        'pack_size',
        'pack_price',
        'price_type',
        'is_published_storefront',
        'is_published_marketplace',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'attributes' => 'array',
        'base_price' => 'decimal:2',
        'price' => 'decimal:2',
        'pack_price' => 'decimal:2',
        'is_published' => 'bool',
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

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
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
