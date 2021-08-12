<?php

namespace App\Actions;

/**
 * Calculates the distance between two coordinates in meters
 */
class CalculateDistanceBetweenCoordinatesAction
{
    /**
     * @var int
     * earth radius in meters
     */
    const EARTH_RADIUS = 6371000;

    /**
     * @see https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
     */
    public function execute(float $latFrom, float $lngFrom, float $latTo, float $lngTo): int
    {
        $latFrom = deg2rad($latFrom);
        $lngFrom = deg2rad($lngFrom);
        $latTo = deg2rad($latTo);
        $lngTo = deg2rad($lngTo);

        $lngDelta = $lngTo - $lngFrom;

        $a = pow(cos($latTo) * sin($lngDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lngDelta), 2);
            
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lngDelta);

        $angle = atan2(sqrt($a), $b);

        return $angle * self::EARTH_RADIUS;
    }
}