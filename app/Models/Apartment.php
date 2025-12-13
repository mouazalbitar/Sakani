<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'details',
        'img1',
        'img2',
        'img3'
    ];

    protected $hidden = [
        'owner_id',
        'city_id',
        'city_data',
        'img1',
        'img2',
        'img3',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        // 'city_name',
        'img1_url',
        'img2_url',
        'img3_url'
    ];

    protected function img1Url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $imgpath = $this->img1;
                if ($imgpath) {
                    return asset(Storage::url($imgpath));
                }
                return null;
            }
        );
    }

    protected function img2Url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $imgpath = $this->img2;
                if ($imgpath) {
                    return asset(Storage::url($imgpath));
                }
                return null;
            }
        );
    }

    protected function img3Url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $imgpath = $this->img3;
                if ($imgpath) {
                    return asset(Storage::url($imgpath));
                }
                return null;
            }
        );
    }

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
