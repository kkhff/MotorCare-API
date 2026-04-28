<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Motorcycle;

#[Fillable(['motorcycle_id', 'distance_km', 'trip_type'])]
class Trip extends Model
{
    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
