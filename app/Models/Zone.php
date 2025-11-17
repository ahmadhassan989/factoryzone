<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'region',
        'city',
        'notes',
    ];

    public function factories()
    {
        return $this->hasMany(Factory::class);
    }
}

