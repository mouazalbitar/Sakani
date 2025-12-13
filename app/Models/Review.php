<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'apertment_id',
        'tenant_id',
        'rating',
        'comment'
    ];
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id', 'id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }
}
