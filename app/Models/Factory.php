<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'zone_id',
        'name',
        'legal_name',
        'slug',
        'country',
        'city',
        'contact_name',
        'contact_email',
        'contact_phone',
        'logo_path',
        'primary_color',
        'secondary_color',
        'preferred_locale',
        'description',
        'industries',
        'capabilities',
        'certifications',
        'google_maps_url',
        'status',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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

