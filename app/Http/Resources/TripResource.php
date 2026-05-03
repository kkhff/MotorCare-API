<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'motorcycle_name' => $this->motorcycle->motorcycle_name,
            'distance_km' => $this->distance_km,
            'trip_type' => $this->trip_type,
            'new_current_km' => $this->motorcycle->current_km,
            'created_at' => $this->created_at->format('d M Y H:i'),
        ];
    }
}
