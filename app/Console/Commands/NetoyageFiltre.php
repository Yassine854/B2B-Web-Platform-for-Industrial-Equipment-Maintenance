<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Console\Command;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;

class NetoyageFiltre extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netoyageFiltre:notify';

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
            $client = User::where('id', $assignment->client_id)->where('role', 1)->first();
            if ($client) {
                $message = "N'oubliez pas de nettoyer le filtre de la pompe ".$assignment->product[0]->name; // Change this to your desired message.
                Notification::send($client, new ClientNotification($message));
            }
        }
    }
}
