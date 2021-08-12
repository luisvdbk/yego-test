<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DisplayRidesStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rides:display-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays stats from rides in different formats';

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
    public function handle()
    {
        $byDay = DB::table('rides')
            ->select(DB::raw('DATE(created_at) as day, COUNT(*) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();
        

        $this->table(
            ['Date', 'Number of Rides'],
            $this->asArrayForTable($byDay)
        );

        return 0;
    }

    private function asArrayForTable(Collection $collection): array
    {
        return $collection->map(fn ($item) => (array) $item)->toArray();
    }
}
