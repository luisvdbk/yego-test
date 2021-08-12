<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class Vehicle extends DataTransferObject
{
    public int $id;

    public string $name;

    public float $lat;

    public float $lng;

    public int $battery;

    public int $type;
}