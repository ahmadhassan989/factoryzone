<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'buyer_id',
        'factory_id',
        'status',
        'currency',
        'subtotal',
        'total',
        'source',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

