<?php

namespace Tests\Feature\Models;

use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;
    
    public function testItUpdatesCoordinatesAndCreatesARideIfDisnatceBetweenOldAndNewCoordinatesIsMoreOrEqualThan60Meters()
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
            // only last decimal changed, this coordinates won't be updated
            'lat' => 41.446885,
            'lng' => 2.245077,
        ]);

        $this->assertEquals(41.381821, $vehicleA->lat);
        $this->assertEquals(2.172203, $vehicleA->lng);

        $this->assertEquals(41.446884, $vehicleB->lat);
        $this->assertEquals(2.245076, $vehicleB->lng);

        $rides = Ride::all();

        $this->assertCount(1, $rides);
        $this->assertEquals($vehicleA->id, $rides[0]->vehicle_id);
    }
}
