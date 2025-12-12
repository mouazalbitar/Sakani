<?php

namespace App\Models;

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
        
    ];

    public function cityData()
    {
        return $this->belongsTo(City::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
