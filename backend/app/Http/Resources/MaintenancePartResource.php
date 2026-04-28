<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenancePartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentKm = $this->motorcycle->current_km;
        $nextReplaceAt = $this->last_replace_km + $this->interval_km;
        $remainingKm = $nextReplaceAt - $currentKm;

        return [
            'part_name' => $this->part_name,
            'interval_km' => $this->interval_km,
            'last_replace_km' => $this->last_replace_km,
            'next_replace_at' => $nextReplaceAt,
            'remaining_km' => max(0, $remainingKm),
            'status' => $remainingKm <= 0 ? 'Wajib ganti' : 'Aman',
            'is_override' => $remainingKm <= 0,
        ];
    }
}
