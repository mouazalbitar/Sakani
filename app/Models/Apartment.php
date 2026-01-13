<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        'images'
    ];


    protected $hidden = [
        'user_relation',
        'governorate_id',
        'city_id',
        'gov_relation',
        'city_relation',
        'images',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'owner',
        'city',
        'governorate',
        'rating',
        'all_images',
        'is_tenant'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function getAllImagesAttribute()
    {
        if (is_array($this->images)) {
            return array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->images);
        }

        return [];
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
    // public function reviewsApartment(){
    //     return $this->reviews()->avg('rating');
    // }
    public function getRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 2);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getIsTenantAttribute()
    {
        $user = Auth::user()->id;
        return Booking::where('apartment_id', $this->id)
            ->where('tenant_id', $user)
            ->where('status', 'approved')
            ->where('end_date', '<', now())
            ->exists();
    }
}
