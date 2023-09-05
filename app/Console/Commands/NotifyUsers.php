<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clients:notify';

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
                //Changement de huile
                if ($assignment->c_huile){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_c_huile));
                    if ($diffInDays == 10){
                        $message = "Changement de huile pour la pompe ".$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message));
                    }
                 }
                 //Changement de filtre
                 if ($assignment->c_filtre){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_c_filtre));
                    if ($diffInDays == 10){
                        $message = "Changement des cartouches de filtres pour la pompe ".$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message));
                    }
                 }
                 //Changement des déshuilleurs
                 if ($assignment->c_dehuil){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_c_dehuil));
                    if ($diffInDays == 10){
                        $message = "Changement des déshuileurs pour la pompe ".$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message));
                    }
                 }
                 //Entretien génerale
                 if ($assignment->entretien){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_entretien));
                    if ($diffInDays == 10){
                        $message = "Entretien génerale pour la pompe ".$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message));
                    }
                 }
            }
        }
    }
}
