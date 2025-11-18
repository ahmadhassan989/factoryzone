<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name_en',
        'name_ar',
        'status',
    ];

    public function factories()
    {
        return $this->hasMany(Factory::class);
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
