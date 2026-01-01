<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'apartment_id',
        'tenant_id'
    ];

    protected $hidden = [
        'apartment_id',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'apartment'
    ];

    public function apartment_relation()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }

    public function getApartmentAttribute(){
        return $this->apartment_relation->makeHidden([
            'owner_id',
            'owner'
        ]);
    }
}
