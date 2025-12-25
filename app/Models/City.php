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
        'govId',
        'created_at',
        'updated_at'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // public function apartments()
    // {
    //     return $this->hasMany(Apartment::class);
    // }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'govId', 'id');
    }
    // public function getGovernorateAttribute(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn() => $this->governorate() ?? null
    //     );
    // }
}
