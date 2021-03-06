<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\SyncVehiclesCommand;
use App\Models\Vehicle;
use App\Repositories\Fake\FakeVehicleRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncVehicleTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewVehiclesAndUpdatesExistentOnes()
    {
        $this->app->bind(VehicleRepository::class, FakeVehicleRepository::class);

        $existentVehicle = Vehicle::factory()->create([
            "id" => 1640,
            "name" => "Susi",
            "lat" => 45.376497,
            "lng" => 5.139018,
            "battery" => 63,
            "type" => 2,
        ]);

        $this->artisan(SyncVehiclesCommand::class)->assertExitCode(0);
    
        $vehiclesById = Vehicle::all()->keyBy('id');

        $this->assertCount(3, $vehiclesById);

        $vehicleA = $vehiclesById[1640];
        
        $this->assertEquals('Susi', $vehicleA->name);
        $this->assertEquals(41.376497, $vehicleA->lat);
        $this->assertEquals(2.139018, $vehicleA->lng);
        $this->assertEquals(63, $vehicleA->battery);
        $this->assertEquals(1, $vehicleA->type);

        $vehicleB = $vehiclesById[1639];
        
        $this->assertEquals('Suneo', $vehicleB->name);
        $this->assertEquals(41.394477, $vehicleB->lat);
        $this->assertEquals(2.112885, $vehicleB->lng);
        $this->assertEquals(93, $vehicleB->battery);
        $this->assertEquals(2, $vehicleB->type);

        $vehicleC = $vehiclesById[1637];
        
        $this->assertEquals('Stephen', $vehicleC->name);
        $this->assertEquals(41.35997, $vehicleC->lat);
        $this->assertEquals(2.133238, $vehicleC->lng);
        $this->assertEquals(87, $vehicleC->battery);
        $this->assertEquals(3, $vehicleC->type);
    }

    public function testInCaseOfAnExceptionAMessageIsShown()
    {
        $this->app->instance(VehicleRepository::class, (new FakeVehicleRepository)->throws());

        $this->artisan(SyncVehiclesCommand::class)
            ->expectsOutput('There was an error trying to get vehicles data. Please, try again later.')
            ->assertExitCode(1);
    }
}
