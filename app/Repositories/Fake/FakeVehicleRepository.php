<?php

namespace App\Repositories\Fake;

use App\DataTransferObjects\Collections\VehicleCollection;
use App\Repositories\VehicleRepository;

class FakeVehicleRepository implements VehicleRepository
{
    public function all(): VehicleCollection
    {
        $fakeData = [
            [
                "id" => 1640,
                "name" => "Susi",
                "lat" => 41.376497,
                "lng" => 2.139018,
                "battery" => 63,
                "type" => 0,
            ],
            [
                "id" => 1639,
                "name" => "Suneo",
                "lat" => 41.394477,
                "lng" => 2.112885,
                "battery" => 93,
                "type" => 0,
            ],
            [ 
                "id" => 1637,
                "name" => "Stephen",
                "lat" => 41.35997,
                "lng" => 2.133238,
                "battery" => 87,
                "type" => 0,
            ],
        ];

        return VehicleCollection::fromApi($fakeData); 
    }
}