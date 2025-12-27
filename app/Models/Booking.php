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

    protected $hidden = [
        'user_relation',
        'apartment'
    ];

    protected $appends = [
        'tenant',
        'owner',
        'owner_id',
    ];

    public function user_relation(){
        return $this->belongsTo(User::class, 'tenant_id', 'id');
    }

    public function getTenantAttribute()
    {
        return $this->user_relation->firstName . ' ' . $this->user_relation->lastName;
    }

    public function getOwnerAttribute()
    {
        return $this->apartment->user_relation->firstName . ' ' . $this->apartment->user_relation->lastName;
    }

    public function getOwnerIdAttribute()
    {
        return $this->apartment->owner_id;
    }

    public function apartment(){
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }
}
