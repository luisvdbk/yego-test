<?php

namespace Database\Seeders;

use App\Models\Ride;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect()->times(5)->each(function (int $i) {
            Ride::factory()->times(rand(10, 100))->create([
                'created_at' => now()->subDays($i),
            ]);
        });
    }
}
