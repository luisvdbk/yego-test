<?php

namespace App\Repositories\Fake;

use App\DataTransferObjects\Collections\VehicleCollection;
use App\Repositories\VehicleRepository;

class FakeVehicleRepository implements VehicleRepository
{
    protected bool $throwsException = false;

    public function all(): VehicleCollection
    {
        if ($this->throwsException) {
            throw new \Exception('Error while trying to get vehicles');
        }

        $fakeData = [
            [
                "id" => 1640,
                "name" => "Susi",
                "lat" => 41.376497,
                "lng" => 2.139018,
                "battery" => 63,
                "type" => 1,
            ],
            [
                "id" => 1639,
                "name" => "Suneo",
                "lat" => 41.394477,
                "lng" => 2.112885,
                "battery" => 93,
                "type" => 2,
            ],
            [ 
                "id" => 1637,
                "name" => "Stephen",
                "lat" => 41.35997,
                "lng" => 2.133238,
                "battery" => 87,
                "type" => 3,
            ],
        ];

        return VehicleCollection::fromApi($fakeData); 
    }

    public function throws(): static
    {
        $this->throwsException = true;

        return $this;
    }
}