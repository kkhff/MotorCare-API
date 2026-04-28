<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MaintenancePartResource;

class MotorcycleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'motorcycle_name' => $this->motorcycle_name,
            'brand' => $this->brand,
            'curremt_km' => $this->current_km,
            'parts' => MaintenancePartResource::collection($this->whenLoaded('maintenance')),
        ];
    }
}
