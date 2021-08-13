<?php

namespace Database\Seeders;

use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Vehicle::truncate();
        Ride::truncate();

        collect()->times(1000)->each(function () {
            Ride::factory()->create([
                'created_at' => now()->subDays(rand(1, 5))->setHour(rand(0, 24)),
            ]);
        });
        
        Schema::enableForeignKeyConstraints();
    }
}
