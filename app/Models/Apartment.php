<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Apartment extends Model
{
    protected $fillable = [
        'owner_id',
        'governorate_id',
        'city_id',
        'price',
        'rooms',
        'size',
        'condition',
        'is_approved',
        'details',
        'img1',
        'img2',
        'img3'
    ];

    protected $hidden = [
        'owner_id',
        'img1',
        'img2',
        'img3',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'img1_url',
        'img2_url',
        'img3_url'
    ];

    public function getImg1UrlAttribute(): ?string
    {
        if ($this->img1) {
            return asset('storage/' . $this->img1);
        }
        return null;
    }
    public function getImg2UrlAttribute(): ?string
    {
        if ($this->img2) {
            return asset('storage/' . $this->img2);
        }
        return null;
    }
    public function getImg3UrlAttribute(): ?string
    {
        if ($this->img3) {
            return asset('storage/' . $this->img3);
        }
        return null;
    }

    public function gov_relation()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id', 'id');
    }

    public function city_relation()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
