<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'owner_id' => $this->owner_id,
            'governorate' => $this->governorate,
            'city_name' => $this->city_name,
            'street' => $this->street,
            'price' => $this->price,
            'rooms' => $this->rooms,
            'size' => $this->size,
            'condition' => $this->condition,
            'is_approved' => $this->is_approved,
            'details' => $this->details,
            'img1' => $this->img1_url,
            'img2' => $this->img2_url,
            'img3' => $this->img3_url
        ];
    }
}
