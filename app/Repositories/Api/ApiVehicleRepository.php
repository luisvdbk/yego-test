<?php

namespace App\Repositories\Api;

use App\DataTransferObjects\Collections\VehicleCollection;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiVehicleRepository extends YegoApiRepository implements VehicleRepository
{
    public function all(): VehicleCollection
    {
        $vehiclesData = $this->client
            ->retry(3, 100)
            ->get('/vehicles')
            ->throw()->json();

        
        return VehicleCollection::fromApi($vehiclesData);
    }
}