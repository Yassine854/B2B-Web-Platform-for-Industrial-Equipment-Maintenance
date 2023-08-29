<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assignment;
use Illuminate\Support\Carbon;
class UpdateHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
{
    
    $assignments = Assignment::all();

    foreach ($assignments as $assignment) {
        $updatedHour = $assignment->c_huile - 1;
        $assignment->update(['c_huile' => $updatedHour]);
    }
}

}
