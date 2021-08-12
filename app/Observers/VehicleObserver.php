<?php

namespace App\Observers;

use App\Actions\CalculateDistanceBetweenCoordinatesAction;
use App\Models\Ride;
use App\Models\Vehicle;

class VehicleObserver
{
    public function updated(Vehicle $vehicle): void
    {
        $this->checkForNewRide($vehicle);
    }

    protected function checkForNewRide(Vehicle $vehicle): void
    { 
        $distanceFromPreviousPosition = $vehicle->distanceFrom(
            $vehicle->getOriginal('lat'),
            $vehicle->getOriginal('lng')
        );

        if ($distanceFromPreviousPosition < 60) {
            return;
        }

        (new Ride())->vehicle()->associate($vehicle)->save();
    }
}
