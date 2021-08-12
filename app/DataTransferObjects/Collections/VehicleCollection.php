<?php

namespace App\DataTransferObjects\Collections;

use App\DataTransferObjects\Vehicle;
use Illuminate\Support\Collection;

class VehicleCollection extends Collection
{
    public function offsetGet($key): Vehicle
    {
        return parent::offsetGet($key);
    }

    public static function fromApi(array $vehiclesData)
    {
        return new static(array_map(
            fn (array $data) => new Vehicle($data),
            $vehiclesData
        ));
    }
}