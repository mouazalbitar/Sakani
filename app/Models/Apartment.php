<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'owner_id',
        'governorate',
        'city_id',
        'street',
        'price',
        'rooms',
        'size',
        'condition',
        'img1',
        'img2',
        'img3'
    ];

    protected $hidden = [
        'number_verified_at',
        'city_id',
        'city_data',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'city_name',
    ];

    public function cityData()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    protected function cityName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->cityData->city ?? null
        );
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
