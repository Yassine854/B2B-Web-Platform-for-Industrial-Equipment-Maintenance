<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Console\Command;
use App\Notifications\ClientNotification;
use App\Notifications\SendEmailNotification;
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
                        //app notifications
                        $message = "Changement de huile pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message,"warning"));

                        //Email notification
                    $details = new SendEmailNotification([
                    'greeting' => 'Cher(e) '.$client->society,
                    'body' => "Changement de huile pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !",
                ]);

                Notification::send($client,$details);
                    }
                 }
                 //Changement de filtre
                 if ($assignment->c_filtre){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_c_filtre));
                    if ($diffInDays == 10){
                        //App notification
                        $message = "Changement des cartouches de filtres pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message,"warning"));

                    //Email notification
                    $details = new SendEmailNotification([
                        'greeting' => 'Cher(e) '.$client->society,
                        'body' => "Changement des cartouches de filtres pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !",
                    ]);
                    Notification::send($client,$details);
                    }
                 }
                 //Changement des déshuilleurs
                 if ($assignment->c_dehuil){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_c_dehuil));
                    if ($diffInDays == 10){
                        //App notification
                        $message = "Changement des déshuileurs pour la pompe ".$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message,"warning"));

                    //Email notification
                    $details = new SendEmailNotification([
                        'greeting' => 'Cher(e) '.$client->society,
                        'body' => "Changement des déshuileurs pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !",
                    ]);
                    Notification::send($client,$details);
                    }
                 }
                 //Entretien génerale
                 if ($assignment->entretien){
                    $now =Carbon::now();
                    $diffInDays = $now->diffInDays(Carbon::parse($assignment->updated_entretien));
                    if ($diffInDays == 10){
                        //App notification
                        $message = "Entretien génerale pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !"; // Change this to your desired message.
                        Notification::send($client, new ClientNotification($message,"warning"));

                    //Email notification
                    $details = new SendEmailNotification([
                        'greeting' => 'Cher(e) '.$client->society,
                        'body' => "Entretien génerale pour la pompe ".$assignment->product[0]->id.'-'.$assignment->product[0]->name." dans 10 jours !",
                    ]);
                    Notification::send($client,$details);
                    }
                 }
            }
        }
    }
}
