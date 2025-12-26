<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'apartment_id',
        'tenant_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $appends = [];

    public function user(){
        return $this->belongsTo(User::class, 'tenant_id', 'id');
    }

    public function apartment(){
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }
}
