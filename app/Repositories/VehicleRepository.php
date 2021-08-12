<?php

namespace App\Repositories;

use App\DataTransferObjects\Collections\VehicleCollection;

interface VehicleRepository
{
    public function all(): VehicleCollection;
}