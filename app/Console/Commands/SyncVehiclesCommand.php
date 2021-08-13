<?php

namespace App\Console\Commands;

use App\DataTransferObjects\Vehicle as VehicleDto;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use Illuminate\Console\Command;

class SyncVehiclesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs local vehicles db data from repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(VehicleRepository $vehicleRepository)
    {
        try {
            $vehicles = $vehicleRepository->all();
        } catch (\Exception $e) {
            $this->error('There was an error trying to get vehicles data. Please, try again later.');
            return 1;
        }

        $vehicles->each(function (VehicleDto $vehicleDto) {
            Vehicle::updateOrCreate(
                ['id' => $vehicleDto->id],
                [
                    'name' => $vehicleDto->name,
                    'lat' => $vehicleDto->lat,
                    'lng' => $vehicleDto->lng,
                    'battery' => $vehicleDto->battery,
                    'type' => $vehicleDto->type,
                ]
            );
        });

        return 0;
    }
}
