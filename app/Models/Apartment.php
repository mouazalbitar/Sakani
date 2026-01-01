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
        'img1_path',
        'img2_path',
        'img3_path'
    ];

    protected $hidden = [
        'user_relation',
        'governorate_id',
        'city_id',
        'gov_relation',
        'city_relation',
        'img1_path',
        'img2_path',
        'img3_path',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'owner',
        'city',
        'governorate',
        'img1',
        'img2',
        'img3'
    ];

    public function getImg1Attribute()
    {
        if ($this->img1_path) {
            return asset('storage/' . $this->img1_path);
        }
        return null;
    }
    public function getImg2Attribute()
    {
        if ($this->img2_path) {
            return asset('storage/' . $this->img2_path);
        }
        return null;
    }
    public function getImg3Attribute()
    {
        if ($this->img3_path) {
            return asset('storage/' . $this->img3_path);
        }
        return null;
    }

    public function gov_relation()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id', 'id');
    }

    public function getGovernorateAttribute()
    {
        return $this->gov_relation->governorate;
    }

    public function city_relation()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function getCityAttribute()
    {
        return $this->city_relation->city;
    }

    public function user_relation()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function getOwnerAttribute()
    {
        return $this->user_relation->firstName . ' ' . $this->user_relation->lastName;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
