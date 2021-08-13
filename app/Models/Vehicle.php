<?php

namespace App\Models;

use App\Actions\CalculateDistanceBetweenCoordinatesAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * @var string
     * 
     * Distance between rides in meters
     */
    const DISTANCE_BETWEEN_RIDES = 60;

    /**
     * Distance between the vehicle position and given position in meters
     */
    public function distanceFrom(float $lat, float $lng): int
    {
        return app(CalculateDistanceBetweenCoordinatesAction::class)->execute(
            $this->lat,
            $this->lng,
            $lat,
            $lng
        );
    }
}
