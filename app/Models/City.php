<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'city'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $appends = [
        'govName'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // public function apartments()
    // {
    //     return $this->hasMany(Apartment::class);
    // }
    public function gov_relation()
    {
        return $this->belongsTo(Governorate::class, 'govId', 'id');
    }
    public function getGovNameAttribute(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gov_relation->governorate
        );
    }
}
