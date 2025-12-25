<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'govId',
        'city'
    ];
    protected $hidden = [
        'gov_relation',
        'created_at',
        'updated_at'
    ];
    protected $appends = [
        'governorate'
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
    public function getGovernorateAttribute()
    {
        return  $this->gov_relation->governorate;
    }
}
