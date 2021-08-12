<?php

namespace App\Console\Commands;

use Exception;
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
                            {date? : displays the number of rides done each day from this date}';

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
        try {
            $byDay = DB::table('rides')
                ->select(DB::raw('DATE(created_at) as day, COUNT(*) as total'))
                ->groupBy('day')
                ->orderBy('day')
                ->when($this->getDate(), function (Builder $query, $date) {
                    return $query->where('created_at', '>=', $date);
                })
                ->get();    
        } catch (\Exception $e) {
            return 1;
        }

        $this->table(
            ['Date', 'Number of Rides'],
            $this->asArrayForTable($byDay)
        );

        return 0;
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
            $this->error($validator->errors()->first('date'));

            throw new Exception('Date validation failed');
        }

        return $date;
    }

    protected function asArrayForTable(Collection $collection): array
    {
        return $collection->map(fn ($item) => (array) $item)->toArray();
    }
}
