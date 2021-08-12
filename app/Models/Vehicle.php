<?php

namespace App\Models;

use App\Actions\CalculateDistanceBetweenCoordinatesAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'integer';
    
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
