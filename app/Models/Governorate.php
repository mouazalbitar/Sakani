<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = [
        'governorate'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function cities(){
        return $this->hasMany(City::class);
    }
}
