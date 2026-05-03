<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\MaintenancePart;
use App\Models\Trip;
use App\Models\User;

#[Fillable(['user_id', 'motorcycle_name', 'brand', 'current_km'])]
class Motorcycle extends Model
{
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function maintenance()
    {
        return $this->hasMany(MaintenancePart::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
