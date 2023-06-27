<?php

namespace App\Console\Commands;

use App\Models\Coordinate;
use Illuminate\Console\Command;

class DeleteCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oneMinuteAgo = now()->subMinute();
        Coordinate::where('created_at', '<=', $oneMinuteAgo)
            ->delete();
    }
}
