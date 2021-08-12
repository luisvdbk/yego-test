<?php

namespace Tests\Feature\Models;

use App\Actions\CalculateDistanceBetweenCoordinatesAction;
use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;
    
    public function testItCreatesANewRideIfDistanceChangedBy60metersOrMore()
    {
        $vehicleA = Vehicle::factory([
            'lat' => 41.446884,
            'lng' => 2.245076,
        ])->create();

        $vehicleB = Vehicle::factory([
            'lat' => 41.446884,
            'lng' => 2.245076,
        ])->create();

        $vehicleA->update([
            'lat' => 41.381821,
            'lng' => 2.172203,
        ]);

        $vehicleB->update([
            // only last decimal changed
            'lat' => 41.446885,
            'lng' => 2.245077,
        ]);
        
        $rides = Ride::all();

        $this->assertCount(1, $rides);
        $this->assertEquals($vehicleA->id, $rides[0]->vehicle_id);
    }
}
