<?php

namespace Database\Factories;

use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class RideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ride::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => Vehicle::factory(),
        ];
    }
}
