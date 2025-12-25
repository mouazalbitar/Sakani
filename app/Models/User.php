<?php

namespace App\Models;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'phone_number',
        'password',
        'firstName',
        'lastName',
        'email',
        'type',
        'city_id',
        'birthday',
        'is_approved',
        'photo',
        'id_img'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'number_verified_at',
        'password',
        'remember_token',
        'city_id', // خفيت هاد الرقم لانو هو حقل موجود بالقاعدة 
        'city', // بسبب Accessor بيتحمل هاد الحقل بالرد بسبب العلاقة يلي تنفذت، لهيك بخفيه من الرد
        'photo',
        'id_img',
    ];

    protected $appends = [
        'photo_url',
        'id_img_url',
        'address'
    ]; // ملاحظة: ازا اضفت شي وما عملتلو دالتو بيطلع اكسبشن باسم هاد الشي ومعها attribute

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    protected function getAddressAttribute()
    {
        return $this->city->governorate->governorate . ' - ' . $this->city->city;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. مسار الصورة المخزن في عمود 'photo'
                $imagePath = $this->photo;

                if ($imagePath) {
                    // 2. بناء الرابط العام الكامل
                    // يُفترض أن المسار المخزن هو بالنسبة لـ 'public' disk
                    // نستخدم asset() لضمان الرابط الكامل (http/https)
                    return asset(FacadesStorage::url($imagePath));
                }

                // 3. في حال عدم وجود صورة، يمكن إرجاع null أو رابط صورة افتراضية
                return null;
            },
        );
    }
    protected function idImgUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $imagePath = $this->id_img;
                if ($imagePath)
                    return asset(FacadesStorage::url($imagePath));
                return null;
            },
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}