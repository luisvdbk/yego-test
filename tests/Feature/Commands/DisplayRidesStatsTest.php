<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\DisplayRidesStatsCommand;
use App\Models\Ride;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplayRidesStatsTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIfNoArgumentsAreProvidedDisplaysNumberOfRidesPerDay()
    {
        Ride::factory()->count(1)->create([
            'created_at' => $dayA = now()->subDays(3),
        ]);

        Ride::factory()->count(2)->create([
            'created_at' => $dayB = now()->subDays(2),
        ]);

        Ride::factory()->count(3)->create([
            'created_at' => $dayC = now()->subDays(1),
        ]);

        $this->artisan(DisplayRidesStatsCommand::class)
            ->expectsTable([
                'Date',
                'Number of Rides',
            ], [
                [$dayA->toDateString(), 1],
                [$dayB->toDateString(), 2],
                [$dayC->toDateString(), 3],
            ]);
    }

    public function testIfDateSuppliedOnlyRidesFromThatDayOnAreShown()
    {
        Ride::factory()->count(1)->create([
            'created_at' => $dayA = now()->subDays(3),
        ]);

        Ride::factory()->count(2)->create([
            'created_at' => $dayB = now()->subDays(2),
        ]);

        Ride::factory()->count(3)->create([
            'created_at' => $dayC = now()->subDays(1),
        ]);

        $this->artisan(DisplayRidesStatsCommand::class, ['date' => $dayB->toDateString()])
            ->expectsTable([
                'Date',
                'Number of Rides',
            ], [
                [$dayB->toDateString(), 2],
                [$dayC->toDateString(), 3],
            ]);
    }

    public function testIfProvidedDateMustBeValid()
    {
        $this->artisan(DisplayRidesStatsCommand::class, ['date' => now()->format('Y/m/d')])
            ->expectsOutput('The date does not match the format Y-m-d.')
            ->assertExitCode(1);
    }

    public function testIfOnlyHourlyOptionSuppliedDisplaysNumberOfRidesPerHour()
    {
        Ride::factory()->create([
            'created_at' => now()->subDay()->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(2)->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(3)->setHour(11),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(4)->setHour(12),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(5)->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(5)->setHour(11),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(5)->setHour(12),
        ]);

        $this->artisan(DisplayRidesStatsCommand::class, ['--hourly' => true])
            ->expectsTable([
                'Hour',
                'Number of Rides',
            ], [
                [10, 3],
                [11, 2],
                [12, 2],
            ]);
    }

    public function testIfHourlyOptionAndDateArgumentSuppliedDisplaysNumberOfRidesPerHourOnGivenDate()
    {
        Ride::factory()->create([
            'created_at' => now()->subDay()->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(2)->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => $date = now()->subDays(3)->setHour(10),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(3)->setHour(11),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(3)->setHour(12),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(3)->setHour(12),
        ]);

        Ride::factory()->create([
            'created_at' => now()->subDays(4)->setHour(12),
        ]);

        $this->artisan(DisplayRidesStatsCommand::class, ['date' => $date->format('Y-m-d'), '--hourly' => true])
            ->expectsTable([
                'Hour',
                'Number of Rides',
            ], [
                [10, 1],
                [11, 1],
                [12, 2],
            ]);
    }
}
