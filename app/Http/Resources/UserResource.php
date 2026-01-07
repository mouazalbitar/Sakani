<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static bool $full_resource = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name'=> $this->first_name,
            'created_at' => $this->when(self::$full_resource, $this->created_at),
        ];
    }

    public static function full($resource) {
        self::$full_resource = true;
        self::make($resource);
    }
}
