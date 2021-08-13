<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DisplayRidesStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rides:display-stats 
                            {--H|hourly : display the number of rides by hour rather than by day}
                            {date? : If used with hourly option, displays rides by hour for this date. Otherwise, displays the number of rides done each day from this date. Should be in Y-m-d format}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays rides stats in different daily or hourly';

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
        try {
            $this->option('hourly') ? $this->displayHourly() : $this->displayDaily();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }

    protected function displayHourly()
    {
        $byHour = DB::table('rides')
                ->select(DB::raw('HOUR(created_at) as hour, COUNT(*) as total'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->when($this->getDate(), function (Builder $query, $date) {
                    return $query->whereRaw('DATE(created_at) = ?', [$date]);
                })
                ->get();

        $this->table(
            ['Hour', 'Number of Rides'],
            $this->asArrayForTable($byHour)
        );
    }

    protected function displayDaily()
    {
        $byDay = DB::table('rides')
                ->select(DB::raw('DATE(created_at) as day, COUNT(*) as total'))
                ->groupBy('day')
                ->orderBy('day')
                ->when($this->getDate(), function (Builder $query, $date) {
                    return $query->where('created_at', '>=', $date);
                })
                ->get();

        $this->table(
            ['Date', 'Number of Rides'],
            $this->asArrayForTable($byDay)
        );
    }

    protected function getDate(): ?string
    {
        if (!$date = $this->argument('date')) {
            return null;
        }

        $validator = Validator::make(
            ['date' => $date], 
            ['date' => 'date_format:Y-m-d']
        );

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first('date'));
        }

        return $date;
    }

    protected function asArrayForTable(Collection $collection): array
    {
        return $collection->map(fn ($item) => (array) $item)->toArray();
    }
}
