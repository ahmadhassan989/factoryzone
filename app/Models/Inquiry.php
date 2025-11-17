<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'factory_id',
        'product_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'quantity',
        'message',
        'source',
        'status',
    ];

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

