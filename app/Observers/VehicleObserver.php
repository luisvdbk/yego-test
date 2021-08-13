<?php

namespace App\Observers;

use App\Models\Ride;
use App\Models\Vehicle;

class VehicleObserver
{
    public function updating(Vehicle $vehicle): void
    {
        if (!$this->positionChanged($vehicle)) {
            return;
        }

        $distanceFromPreviousPosition = $vehicle->distanceFrom(
            $originalLat = $vehicle->getOriginal('lat'),
            $originalLng = $vehicle->getOriginal('lng')
        );

        if ($distanceFromPreviousPosition < Vehicle::DISTANCE_BETWEEN_RIDES) {
            $vehicle->lat = $originalLat;
            $vehicle->lng = $originalLng;
        }
    }

    public function updated(Vehicle $vehicle): void
    {
        if (!$this->positionChanged($vehicle)) {
            return;
        }

        (new Ride())->vehicle()->associate($vehicle)->save();
    }

    protected function positionChanged(Vehicle $vehicle): bool
    {
        return $vehicle->isDirty('lat') || $vehicle->isDirty('lng');
    }
}
