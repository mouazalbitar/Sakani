<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{ // لبعدين , لا تنسى يكون التقييم فريد ع مستوى المستأجر والشقة مع بعض, ولا تنسى تمنع المستخدم من تقييم شقة ما استأجرها
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
