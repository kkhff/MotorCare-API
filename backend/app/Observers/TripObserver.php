<?php

namespace App\Observers;

use App\Models\Trip;

class TripObserver
{
    /**
     * Handle the Trip "created" event.
     */
    public function created(Trip $trip): void
    {
        $motor = $trip->motorcycle;

        $motor->current_km += $trip->distance_km;

        $motor->save();
    }

    /**
     * Handle the Trip "updated" event.
     */
    public function updated(Trip $trip): void
    {
        if ($trip->wasChange('distance_km')){
            $motor = $trip->motorcycle;

            $difference = $trip->distance_km - $motor->current_km;

            $motor->current_km += $difference;
            $motor->save();
        }
    }

    /**
     * Handle the Trip "deleted" event.
     */
    public function deleted(Trip $trip): void
    {
        $motor = $trip->motorcycle;

        $motor->current_km -= $trip->distance_km;

        $motor->save();
    }

    /**
     * Handle the Trip "restored" event.
     */
    public function restored(Trip $trip): void
    {
        //
    }

    /**
     * Handle the Trip "force deleted" event.
     */
    public function forceDeleted(Trip $trip): void
    {
        //
    }
}
