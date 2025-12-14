<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'apartment_id',
        'tenant_id',
        'rating',
        'comment'
    ];
    protected $hidden = [
        'updated_at',
        'created_at'
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
