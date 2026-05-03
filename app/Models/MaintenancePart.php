<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Motorcycle;

#[Fillable(['motorcycle_id', 'part_name', 'interval_km', 'last_replace_km'])]
class MaintenancePart extends Model
{
    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
